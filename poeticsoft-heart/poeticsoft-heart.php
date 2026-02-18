<?php

/**
 * Plugin Name: Poetic Soft Heart
 * Plugin URI: https://poeticsoft.com/plugins/poeticsoft-heart
 * Description: Heart of Poeticsoft Plugins EcoSystem
 * Version: 0.0.0
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * Author: Poeticsoft Team
 * License: GPL-3.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Author URI: https://poeticsoft.com/team
 * Text Domain: poeticsoft-heart
 * Domain Path: /languages
 */

namespace Poeticsoft;

use Poeticsoft\Heart\Engine;

/**
 * Verificación de seguridad: Evitar acceso directo al archivo.
 */
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Carga del autoloader de Composer.
 */
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

/**
 * Inicialización del motor principal del plugin.
 * Se utiliza el método estático boot para configurar el Singleton.
 */
Engine::boot(__FILE__);

/**
 * Hook de activación.
 *
 * Se ejecuta al activar el plugin. Delega la lógica al motor central.
 */
register_activation_hook(
    __FILE__,
    function () {
        Engine::activate();
    }
);

/**
 * Hook de desactivación.
 *
 * Se ejecuta al desactivar el plugin. Limpia cachés y estados temporales.
 */
register_deactivation_hook(
    __FILE__,
    function () {
        Engine::deactivate();
    }
);
