<?php

namespace Poeticsoft\Heart;

/**
 * Motor central del ecosistema Poeticsoft.
 *
 * Gestiona el ciclo de vida de los plugins, el logging centralizado
 * y la comunicación entre módulos (Forges).
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */
class Engine
{
    /** @var self|null Instancia única (Singleton) */
    private static $instance = null;

    /** @var ForgeInterface[] Lista de módulos registrados */
    private $forges = [];

    /** @var Admin Instancia del gestor administrativo */
    protected $admin;

    /** @var string Versión del core */
    private $version = '0.0.0';

    /** @var string Ruta al archivo principal del plugin */
    private $pluginfile;

    /** @var string Directorio del plugin con slash final */
    private $path;

    /** @var string URL del plugin con slash final */
    private $url;

    /** @var string Nombre base del plugin */
    private $basename;

    /** @var string Ruta completa al archivo de log */
    private $logfile;

    /**
     * Inicializa el motor principal.
     *
     * @param string $pluginfile Ruta absoluta al archivo raíz del plugin.
     * @return self
     * @throws \RuntimeException Si se intenta inicializar más de una vez.
     */
    public static function boot(string $pluginfile)
    {
        if (null !== self::$instance) {
            throw new \RuntimeException('Engine ya fue inicializado.');
        }

        self::$instance = new self($pluginfile);
        return self::$instance;
    }

    /**
     * Obtiene la instancia activa del motor.
     *
     * @return self
     * @throws \RuntimeException Si se llama antes de boot().
     */
    public static function instance()
    {
        if (null === self::$instance) {
            throw new \RuntimeException('Engine no ha sido inicializado. Llama a Engine::boot() primero.');
        }

        return self::$instance;
    }

    /**
     * Constructor privado para forzar el patrón Singleton.
     *
     * @param string $pluginfile
     */
    private function __construct(string $pluginfile)
    {
        $this->pluginfile = $pluginfile;
        $this->path       = plugin_dir_path($pluginfile);
        $this->url        = plugin_dir_url($pluginfile);
        $this->basename   = plugin_basename($pluginfile);
        $this->logfile    = WP_CONTENT_DIR . '/poeticsoft-heart-debug.log';

        // Inyectamos el motor en el controlador Admin
        $this->admin = new Admin($this);

        // Hooks de inicialización
        add_action('plugins_loaded', [$this, 'init'], 10);
        add_action('init', [$this, 'wp_init']);

        $this->ensure_log_availability();
    }

    /**
     * Registra un nuevo módulo en el ecosistema.
     *
     * @param string         $id        Identificador único.
     * @param ForgeInterface $instancia El objeto del módulo.
     * @return bool
     * @throws \InvalidArgumentException Si el ID está vacío.
     */
    public function registrar_forge(string $id, ForgeInterface $instancia)
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('El ID del módulo no puede estar vacío');
        }

        $this->forges[$id] = $instancia;
        return true;
    }

    /**
     * Lanza el proceso de inicialización de todos los módulos.
     *
     * @internal Llamado por el hook 'plugins_loaded'.
     */
    public function init()
    {
        do_action('poeticsoft_heart_register', $this);

        foreach ($this->forges as $id => $forge) {
            try {
                $forge->init($this);
            } catch (\Exception $e) {
                $this->log("Error al inicializar Forge {$id}: {$e->getMessage()}", 'ERROR');
            }
        }

        do_action('poeticsoft_heart_booted', $this);
    }

    /**
     * Registra eventos en el log si WP_DEBUG está habilitado.
     *
     * @param mixed  $mensaje Datos a guardar.
     * @param string $nivel   Nivel del log.
     * @param string $forge   Origen del log.
     * @return bool
     */
    public function log($mensaje, string $nivel = 'INFO', string $forge = 'HEART')
    {
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            return false;
        }

        $text = is_string($mensaje) ? $mensaje : wp_json_encode($mensaje, JSON_PRETTY_PRINT);
        $fecha = current_time('Y-m-d H:i:s');
        $entrada = "[{$fecha}] [{$nivel}] [{$forge}]: {$text}" . PHP_EOL;

        // Intentamos escribir en nuestro log, si no, al de WP
        if (is_writable(dirname($this->logfile)) || (file_exists($this->logfile) && is_writable($this->logfile))) {
            return (bool) error_log($entrada, 3, $this->logfile);
        }

        error_log("HEART_LOG_FALLBACK: " . $entrada);
        return false;
    }

    /**
     * Asegura que el archivo de log sea accesible.
     */
    private function ensure_log_availability()
    {
        $log_dir = dirname($this->logfile);
        if (is_writable($log_dir)) {
            if (!file_exists($this->logfile)) {
                file_put_contents($this->logfile, '');
            }
            if (!is_writable($this->logfile)) {
                chmod($this->logfile, 0664);
            }
        }
    }

    /**
     * Getters básicos
     */
    public function get_version()
    {
        return $this->version;
    }
    public function get_logfile()
    {
        return $this->logfile;
    }
    public function get_forges()
    {
        return $this->forges;
    }

    public function wp_init()
    {
        load_plugin_textdomain(
            'poeticsoft-heart',
            false,
            dirname($this->basename) . '/languages'
        );
    }

    public static function activate()
    {
        wp_cache_flush();
    }
    public static function deactivate()
    {
        wp_cache_flush();
    }

    /**
     * Limpieza al desinstalar.
     */
    public static function uninstall()
    {
        // Al ser estático, no podemos usar $this->logfile, usamos instance()
        $instance = self::instance();
        $logfile = $instance->get_logfile();

        if (file_exists($logfile)) {
            @unlink($logfile);

            // Borrar backups .bak
            $backups = glob($logfile . '.*.bak');
            if (is_array($backups)) {
                foreach ($backups as $file) {
                    @unlink($file);
                }
            }
        }

        wp_cache_flush();
        do_action('poeticsoft_heart_uninstall');
    }
}
