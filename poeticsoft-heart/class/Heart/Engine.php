<?php

namespace Poeticsoft\Heart;

/**
 * Motor central del ecosistema Poeticsoft.
 *
 * Gestiona el ciclo de vida de los módulos (Forges), el registro centralizado
 * de logs y la inicialización de componentes administrativos del núcleo.
 *
 * @package Poeticsoft\Heart
 * @version 1.0.0
 * @since   2026-02-18
 */
class Engine
{
    /** * @var self|null Almacena la instancia única del motor siguiendo el patrón Singleton.
     */
    private static ?self $instance = null;

    /** * @var ForgeInterface[] Colección de módulos registrados que implementan la interfaz Forge.
     */
    private array $forges = [];

    /** * @var Admin Controlador del área de administración de WordPress.
     */
    protected Admin $admin;

    /** * @var string Versión actual del núcleo Heart. Inmutable tras la creación.
     */
    private readonly string $version;

    /** * @var string Ruta absoluta al archivo de entrada del plugin (main file).
     */
    private readonly string $pluginfile;

    /** * @var string Directorio raíz del plugin con slash final (trailingslashit).
     */
    private readonly string $path;

    /** * @var string URL pública del directorio del plugin.
     */
    private readonly string $url;

    /** * @var string Identificador único de WordPress basado en el path del plugin.
     */
    private readonly string $basename;

    /** * @var string Ruta completa al archivo de depuración personalizado del ecosistema.
     */
    private readonly string $logfile;

    /** * @var string Token de autenticación global.
     */
    private ?string $token = null;

    /**
     * Prevenir la clonación del objeto para mantener la integridad del Singleton.
     */
    private function __clone()
    {
    }

    /**
     * Prevenir la deserialización para evitar duplicidad de instancias en memoria.
     * * @throws \Exception Siempre, para bloquear el uso de unserialize().
     */
    public function __wakeup()
    {
        throw new \Exception("No se puede deserializar un Singleton.");
    }

    /**
     * Punto de entrada principal para arrancar el motor.
     *
     * @param string $pluginfile Ruta absoluta (__FILE__) del plugin que invoca el motor.
     * @return self La instancia única inicializada.
     * @throws \RuntimeException Si se intenta ejecutar boot() más de una vez.
     */
    public static function boot(string $pluginfile): self
    {
        if (null !== self::$instance) {
            throw new \RuntimeException('Engine ya fue inicializado.');
        }

        self::$instance = new self($pluginfile);
        return self::$instance;
    }

    /**
     * Acceso global a la instancia del motor.
     *
     * @return self Instancia activa del Engine.
     * @throws \RuntimeException Si se llama antes de haber ejecutado boot().
     */
    public static function get_instance(): self
    {
        if (null === self::$instance) {
            throw new \RuntimeException('Engine no ha sido inicializado. Llama a Engine::boot() primero.');
        }
        return self::$instance;
    }

    /**
     * Constructor privado. Configura el entorno y las constantes de ruta.
     * * @param string $pluginfile
     */
    private function __construct(string $pluginfile)
    {
        // Configuración inmutable del entorno
        $this->version = '1.0.0';
        $this->pluginfile = $pluginfile;
        $this->path = plugin_dir_path($pluginfile);
        $this->url = plugin_dir_url($pluginfile);
        $this->basename = plugin_basename($pluginfile);
        $this->logfile = WP_CONTENT_DIR . '/poeticsoft-heart-debug.log';

        // Inyección del motor en el controlador administrativo
        $this->admin = new Admin($this);

        add_action('init', [$this, 'init']);

        $this->ensure_log_availability();
    }

    /**
     * Registra un nuevo módulo (Forge) en el registro central.
     *
     * @param string         $id        Identificador único (slug) para el módulo.
     * @param ForgeInterface $instancia Objeto que cumple el contrato ForgeInterface.
     * @return bool True si el registro fue exitoso.
     * @throws \InvalidArgumentException Si el ID proporcionado es inválido.
     */
    public function registrar_forge(string $id, ForgeInterface $instancia): bool
    {
        if (empty($id)) {
            throw new \InvalidArgumentException('El ID del módulo no puede estar vacío');
        }

        $this->forges[$id] = $instancia;
        return true;
    }

    /**
     * Dispara la inicialización de todos los módulos registrados.
     * Ejecuta hooks de acción para permitir extensiones externas.
     * * @return void
     */
    public function init(): void
    {
        // Hook para que otros plugins registren sus Forges
        do_action('poeticsoft_heart_register', $this);

        foreach ($this->forges as $id => $forge) {
            
            try {
                
                $forge->init($this);
                
            } catch (\Exception $e) {
                
                $this->log("Error al inicializar Forge {$id}: {$e->getMessage()}", 'ERROR');
            }
        }       
        
        load_plugin_textdomain(
            'poeticsoft-heart',
            false,
            dirname($this->basename) . '/languages'
        );

        do_action('poeticsoft_heart_booted', $this);
    }

    /**
     * Escribe eventos en el archivo de log dedicado del sistema.
     * Solo actúa si WP_DEBUG está activo para optimizar rendimiento.
     *
     * @param mixed  $mensaje Datos a registrar (strings o arrays/objetos).
     * @param string $nivel   Categoría del log (INFO, ERROR, DEBUG).
     * @param string $forge   Origen o nombre del módulo que genera el log.
     * @return bool True si se escribió correctamente.
     */
    public function log($mensaje, string $nivel = 'INFO', string $forge = 'HEART'): bool
    {
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            return false;
        }

        $text = is_string($mensaje) ? $mensaje : wp_json_encode($mensaje, JSON_PRETTY_PRINT);
        $fecha = current_time('Y-m-d H:i:s');
        $entrada = "[{$fecha}] [{$nivel}] [{$forge}]: {$text}" . PHP_EOL;

        if (is_writable(dirname($this->logfile)) || (file_exists($this->logfile) && is_writable($this->logfile))) {
            return (bool) error_log($entrada, 3, $this->logfile);
        }

        error_log("HEART_LOG_FALLBACK: " . $entrada);
        return false;
    }

    /**
     * Verifica y prepara el sistema de archivos para el log.
     * Crea el archivo y ajusta permisos si es necesario.
     * * @return void
     */
    private function ensure_log_availability(): void
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

    /** @return string Versión del core. */
    public function get_version(): string
    {
        return $this->version;
    }

    /** @return string Ruta del archivo log. */
    public function get_logfile(): string
    {
        return $this->logfile;
    }

    /** @return ForgeInterface[] Listado de módulos. */
    public function get_forges(): array
    {
        return $this->forges;
    }

    /** @return string Basename del plugin. */
    public function get_basename(): string
    {
        return $this->basename;
    }
    
    /**
     * Obtiene el token de seguridad centralizado cuando se solicita por primera vez.
     * * @return string
     */
    public function get_token(): string
    {
        if (null === $this->token) {
            
            $this->token = wp_create_nonce('poeticsoft_heart_token');
        }

        return $this->token;
    }

    /** Acciones de activación de WordPress. */
    public static function activate(): void
    {
        wp_cache_flush();
    }

    /** Acciones de desactivación de WordPress. */
    public static function deactivate(): void
    {
        wp_cache_flush();
    }

    /**
     * Limpieza profunda del sistema durante la desinstalación.
     * Elimina logs y backups generados por el ecosistema.
     */
    public static function uninstall(): void
    {
        try {
            // Acceso seguro a la instancia para obtener rutas
            $instance = self::get_instance();
            $logfile = $instance->get_logfile();

            if (file_exists($logfile)) {
                @unlink($logfile);
                $backups = glob($logfile . '.*.bak');
                if (is_array($backups)) {
                    foreach ($backups as $file) {
                        @unlink($file);
                    }
                }
            }
        } catch (\Exception $e) {
            // Silenciar si el motor no estaba cargado durante la desinstalación
        }

        wp_cache_flush();
        do_action('poeticsoft_heart_uninstall');
    }
}
