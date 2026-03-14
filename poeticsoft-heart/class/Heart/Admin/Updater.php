<?php

namespace Poeticsoft\Heart\Admin;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

class Updater
{
    // public static function init(string $file, string $slug, string $server_url = '')
    // {
    //     if (!class_exists('YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
    //         \Poeticsoft\log(
    //             "Update Checker no disponible para: {$slug}",
    //             'WARNING',
    //             'UPDATES'
    //         );
    //         return;
    //     }

    //     if (empty($server_url)) {
    //         $server_url = "https://poeticsoft.com/plugins/{$slug}/info.json";
    //     }

    //     try {

    //         $updateChecker = PucFactory::buildUpdateChecker(
    //             $server_url,
    //             $file,
    //             $slug
    //         );

    //         \Poeticsoft\log("Sistema de actualizaciones activo: {$slug}", 'INFO', 'UPDATES');

    //     } catch (\Exception $e) {
    //         \Poeticsoft\log(
    //             "Fallo al iniciar updates para {$slug}: " . $e->getMessage(),
    //             'ERROR',
    //             'UPDATES'
    //         );
    //     }
    // }
}
