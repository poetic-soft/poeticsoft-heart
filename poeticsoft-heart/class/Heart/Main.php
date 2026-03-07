<?php

namespace Poeticsoft\Heart;

use Poeticsoft\H;
use Poeticsoft\Heart\Admin\Main as Admin;
use Poeticsoft\Heart\API\Main as API;
use Poeticsoft\Heart\Forge\Main as Forge;
use Poeticsoft\Heart\UI\Main as UI;

class Main
{
    // -------------------------------------------------------------------------------
    
    public Admin $admin;
    public API $api;
    public Forge $forge;
    public UI $ui;
    
    // -------------------------------------------------------------------------------
    
    private static ?self $instance = null;
    private readonly string $id;
    private readonly string $version;
    private readonly string $plugin_file;
    private readonly string $path;
    private readonly string $url;
    private readonly string $basename;
    private readonly string $log_file;
    
    // -------------------------------------------------------------------------------
    
    public $log;
    
    // -------------------------------------------------------------------------------
    
    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("No se puede deserializar un Singleton.");
    }

    public static function get_instance(): self
    {
        if (null === self::$instance) {
            
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        
        $id = 'poeticsoft-heart';
        $plugin_file = WP_PLUGIN_DIR . '/' . $id . '/' . $id . '.php';
        $log_file = WP_CONTENT_DIR . '/' . $id . '.log';
        
        $this->id = $id;
        $this->version = '0.0.0';
        $this->plugin_file = $plugin_file;
        $this->basename = plugin_basename($plugin_file);
        $this->path = plugin_dir_path($plugin_file);
        $this->url = plugin_dir_url($plugin_file);
        $this->log_file = $log_file;
        
        $this->admin = new Admin($this);
        $this->api = new API($this);
        $this->forge = new Forge($this);
        $this->ui = new UI($this);
    }
    
    // -------------------------------------------------------------------------------
    
    public function get_id(): string
    {
        return $this->id;
    }

    public function get_version(): string
    {
        return $this->version;
    }

    public function get_plugin_file(): string
    {
        return $this->plugin_file;
    }

    public function get_basename(): string
    {
        return $this->basename;
    }

    public function get_path(): string
    {
        return $this->path;
    }

    public function get_url(): string
    {
        return $this->url;
    }

    public function get_log_file(): string
    {
        return $this->log_file;
    }

    // -------------------------------------------------------------------------------
    
    public static function activate(): void
    {
        wp_cache_flush();
    }

    public static function deactivate(): void
    {
        wp_cache_flush();
    }

    // -------------------------------------------------------------------------------
    
    public static function uninstall(): void
    {
        try {
            
            $instance = self::get_instance();
            $log_file = $instance->get_log_file();

            if (file_exists($log_file)) {
                
                @unlink($log_file);
                
                $backups = glob($log_file . '.*.bak');
                
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
    
    // -------------------------------------------------------------------------------
    
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
            is_writable(dirname($this->log_file))
            ||
            (
                file_exists($this->log_file)
                &&
                is_writable($this->log_file)
            )
        ) {
            
            return (bool) error_log(
                $entrada,
                3,
                $this->log_file
            );
        }

        error_log("HEART_LOG_FALLBACK: " . $entrada);
        
        return false;
    }
}
