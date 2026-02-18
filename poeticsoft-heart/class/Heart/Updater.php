<?php

namespace Poeticsoft\Heart;

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * Clase Updater - Gestor de actualizaciones.
 *
 * Facilita la integración con la librería Plugin Update Checker (PUC) para
 * permitir que los plugins del ecosistema se actualicen desde servidores propios.
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */
class Updater
{
    /**
     * Inicializa el mecanismo de actualizaciones para un plugin específico.
     *
     * @param string $file       Ruta absoluta al archivo principal del plugin.
     * @param string $slug       Slug identificador del plugin (ej: 'poeticsoft-heart').
     * @param string $server_url URL del archivo metadata JSON del servidor (opcional).
     * @return void
     */
    public static function init(string $file, string $slug, string $server_url = '')
    {
        // 1. Verificar si la librería está disponible vía Composer
        if (!class_exists('YahnisElsts\PluginUpdateChecker\v5\PucFactory')) {
            \Poeticsoft\log(
                "Update Checker no disponible para: {$slug}",
                'WARNING',
                'UPDATES'
            );
            return;
        }

        // 2. Establecer URL por defecto si no se provee una personalizada
        if (empty($server_url)) {
            $server_url = "https://poeticsoft.com/plugins/{$slug}/info.json";
        }

        try {
            // 3. Construir y registrar el checker
            $updateChecker = PucFactory::buildUpdateChecker(
                $server_url,
                $file,
                $slug
            );

            // Opcional: Configurar autenticación si el servidor lo requiere
            // $updateChecker->setAuthentication('tu-token');

            \Poeticsoft\log("Sistema de actualizaciones activo: {$slug}", 'INFO', 'UPDATES');
        } catch (\Exception $e) {
            \Poeticsoft\log(
                "Fallo al iniciar updates para {$slug}: " . $e->getMessage(),
                'ERROR',
                'UPDATES'
            );
        }
    }
}
