<?php

namespace Poeticsoft;

use Poeticsoft\Heart\Engine;

/**
 * Clase de acceso rápido (Facade) ajustada.
 * Ubicación: class\Heart.php
 */
class Heart
{
    /**
     * Acceso directo al sistema de logs.
     * Ahora acepta el mensaje y lo envía automáticamente al Engine.
     *
     * @param mixed $mensaje Datos a registrar. [cite: 255]
     * @param string $nivel Categoría del log (INFO, ERROR, DEBUG). [cite: 256]
     * @return bool
     */
    public static function log(
        $mensaje = null,
        $nivel = 'INFO',
        $forge = 'HEART'
    ) {
        // Si no se pasa mensaje, seguimos retornando la instancia para mantener compatibilidad
        if ($mensaje === null) {
            
            return Engine::get_instance()->logging;
        }

        // Si hay mensaje, lo enviamos directamente al servicio de logging del Engine
        return Engine::get_instance()->logging->log($mensaje, $nivel, $forge);
    }

    /**
     * Acceso al gestor de interfaz de usuario (UI).
     * * @return \Poeticsoft\Heart\UI
     */
    public static function ui()
    {
        return Engine::get_instance()->ui;
    }

    /**
     * Recupera la instancia de un Forge (plugin) específico por su slug.
     * * @param string $slug Identificador del plugin.
     * @return \Poeticsoft\Heart\ForgeInterface|null
     */
    public static function forge(string $slug)
    {
        $engine = Engine::get_instance();
        return $engine->forges[$slug] ?? null;
    }
    
    /**
     * Acceso al motor central para operaciones avanzadas.
     * * @return \Poeticsoft\Heart\Engine
     */
    public static function engine()
    {
        return Engine::get_instance();
    }
}
