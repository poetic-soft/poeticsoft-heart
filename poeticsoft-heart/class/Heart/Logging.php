<?php

namespace Poeticsoft\Heart;

/**
 * Clase Logging - Registro de eventos & Mensajes
 *
 * @package Poeticsoft\Logging
 * @since 0.0.0
 */
class Logging
{
    /**
     * Instancia del motor principal.
     *
     * @var Engine
     */
    private $engine;

    /** * @var string Ruta completa al archivo de depuración personalizado del ecosistema.
     */
    private readonly string $logfile;

    /**
     * Constructor de la clase Logging.
     *
     * @param Engine $heart Inyección de la instancia del motor.
     */
    public function __construct(Engine $engine)
    {
        // Heart
        $this->engine = $engine;
        
        // Donde escribir el log
        $this->logfile = WP_CONTENT_DIR . '/poeticsoft-heart-debug.log';
        
        // Asegurar escritura de log .
        $this->ensure_log_availability();
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
                
            } else {
            
                /*  DEBUG empty file
                file_put_contents($this->logfile, ''); */
            }
            
        } else {
            
            if (!is_writable($this->logfile)) {
                
                chmod($this->logfile, 0664);
            }
        }
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
    public function log(
        $mensaje,
        string $nivel = 'INFO',
        string $forge = 'HEART'
    ): bool {
        
        if (!defined('WP_DEBUG') || !WP_DEBUG) {
            return false;
        }

        $text = is_string($mensaje) ?
        $mensaje
        :
        json_encode($mensaje, JSON_PRETTY_PRINT);
        $fecha = current_time('Y-m-d H:i:s');
        $entrada = "[{$fecha}] [{$nivel}] [{$forge}]: {$text}" . PHP_EOL;

        if (
            is_writable(dirname($this->logfile))
            ||
            (
                file_exists($this->logfile)
                &&
                is_writable($this->logfile)
            )
        ) {
            
            return (bool) error_log($entrada, 3, $this->logfile);
        }

        error_log("HEART_LOG_FALLBACK: " . $entrada);
        return false;
    }

    /** @return string Ruta del archivo log. */
    public function get_logfile(): string
    {
        return $this->logfile;
    }
}
