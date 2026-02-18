<?php

/**
 * Script de desinstalación de Poeticsoft Heart.
 *
 * Este archivo se ejecuta automáticamente cuando el usuario elimina el plugin.
 * Se encarga de limpiar archivos de log, cachés y notificar a otros módulos.
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */

namespace Poeticsoft;

use Poeticsoft\Heart\Engine;

/**
 * Verificación de seguridad: Si WordPress no llama a este archivo, salimos.
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/**
 * Carga del autoloader de Composer.
 * Necesario para acceder a los métodos estáticos de limpieza del Engine.
 */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Ejecución de la limpieza centralizada.
 * Invocamos el método estático que gestiona el borrado de logs y el flush de caché.
 */
Engine::uninstall();
