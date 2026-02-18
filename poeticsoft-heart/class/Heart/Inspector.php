<?php

namespace Poeticsoft\Heart;

/**
 * Clase Inspector - Diagnóstico y utilidades del sistema.
 *
 * Proporciona herramientas para verificar el estado de salud del motor,
 * los permisos de archivos y la integración de los módulos (Forges).
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */
class Inspector
{
    /**
     * Realiza tests de diagnóstico básicos del entorno.
     *
     * @return array Resumen de estados con iconos de estado (✅, ❌, ⚠️).
     */
    public static function run_diagnostic()
    {
        global $wp_version;

        $engine = Engine::instance();
        $results = [];

        // Comprobaciones de integridad del núcleo
        $results['Engine']    = class_exists('\Poeticsoft\Heart\Engine') ? '✅' : '❌';
        $results['Singleton'] = ($engine === Engine::instance()) ? '✅' : '❌';
        $results['Forges']    = '📦 ' . count($engine->get_forges());

        // Verificación del sistema de Logging
        $logfile = $engine->get_logfile();
        if (empty($logfile)) {
            $results['Log System'] = '⚠️ Ruta no definida';
        } else {
            if (file_exists($logfile)) {
                $results['Log Status'] = is_writable($logfile) ? '✅ Escribible' : '❌ Sin permisos';
            } else {
                $results['Log Status'] = is_writable(dirname($logfile)) ? '✅ Listo para crear' : '❌ Carpeta protegida';
            }
        }

        $results['PHP']       = phpversion();
        $results['WordPress'] = $wp_version;

        return $results;
    }

    /**
     * Obtiene información técnica del sistema para uso interno o APIs.
     *
     * @return array {
     * @type string $php_version       Versión de PHP.
     * @type string $wordpress_version Versión de WP.
     * @type string $plugin_version    Versión de Heart.
     * @type int    $modules_count     Cantidad de módulos registrados.
     * }
     */
    public static function get_system_info()
    {
        global $wp_version;
        $engine = Engine::instance();

        return [
            'php_version'       => phpversion(),
            'wordpress_version' => $wp_version,
            'plugin_version'    => $engine->get_version(),
            'modules_count'     => count($engine->get_forges()),
        ];
    }

    /**
     * Renderiza el panel de información en la administración de WordPress.
     *
     * @internal Invocado por el hook 'admin_notices'.
     * @return void
     */
    public static function render_diagnostic_panel()
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $is_test_mode = (isset($_GET['test_forge']) ? sanitize_key($_GET['test_forge']) : '') === '1';
        if (!$is_test_mode) {
            return;
        }

        // Validación de seguridad mediante Nonce
        if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'poeticsoft_heart_diagnostic')) {
            wp_die(__('Seguridad fallida', 'poeticsoft-heart'));
        }

        $report      = self::run_diagnostic();
        $close_url   = admin_url();
        $refresh_url = wp_nonce_url(admin_url('?test_forge=1'), 'poeticsoft_heart_diagnostic');

        ?>
        <div class="notice notice-info" style="padding: 20px; border-left-color: #722ed1;">
            <h2 style="margin-top:0;">🛡️ <?php esc_html_e('Informe Heart & Forge', 'poeticsoft-heart'); ?></h2>
            <ul style="
                list-style: none;
                font-size: 1.1em;
                background: #f0f0f1;
                padding: 15px;
                border-radius: 4px;
                border: 1px solid #dcdcde;
            ">
                <?php foreach ($report as $test => $status) : ?>
                    <li style="margin-bottom: 5px;">
                        <strong><?php echo esc_html($test); ?>:</strong>
                        <span style="float: right;"><?php echo esc_html($status); ?></span>
                        <div style="clear:both;"></div>
                    </li>
                <?php endforeach; ?>
            </ul>
            <p>
                <a href="<?php echo esc_url($close_url); ?>" class="button">
                    <?php esc_html_e('Cerrar', 'poeticsoft-heart'); ?>
                </a>
                <a href="<?php echo esc_url($refresh_url); ?>" class="button button-primary">
                    <?php esc_html_e('Actualizar', 'poeticsoft-heart'); ?>
                </a>
            </p>
        </div>
        <?php
    }

    /**
     * Añade el enlace de "Diagnóstico" dinámicamente en la tabla de plugins.
     *
     * @param array $links Enlaces existentes (Desactivar, Editar, etc.).
     * @return array Enlaces modificados.
     */
    public static function add_action_link($links)
    {
        $url  = wp_nonce_url(admin_url('?test_forge=1'), 'poeticsoft_heart_diagnostic');
        $link = sprintf(
            '<a href="%s" style="font-weight:bold; color:#722ed1;">%s</a>',
            esc_url($url),
            esc_html__('Diagnóstico', 'poeticsoft-heart')
        );

        array_unshift($links, $link);
        return $links;
    }
}