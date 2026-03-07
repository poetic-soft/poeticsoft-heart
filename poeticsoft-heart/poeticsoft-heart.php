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

/**
 * Update composer classmap
 * composer dump-autoload -o
 */

namespace Poeticsoft;

use Poeticsoft\Heart\main as Heart;

if (!defined('ABSPATH')) {
    exit;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

new Heart();

register_activation_hook(
    __FILE__,
    function () {
        Heart::activate();
    }
);

register_deactivation_hook(
    __FILE__,
    function () {
        Heart::deactivate();
    }
);
