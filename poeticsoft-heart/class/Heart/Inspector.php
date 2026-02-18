<?php

namespace Poeticsoft\Heart;

/**
 * Clase Inspector - Diagnóstico y utilidades del sistema.
 */
class Inspector
{
    /**
     * Realiza tests de diagnóstico básicos del entorno.
     *
     * @return array Resumen de estados con iconos.
     */
    public static function run_diagnostic(): array
    {
        global $wp_version;

        $engine  = Engine::get_instance();
        $results = [];

        // Comprobaciones de integridad del núcleo
        $results['Engine']    = class_exists('\Poeticsoft\Heart\Engine') ? '✅' : '❌';
        $results['Singleton'] = ($engine === Engine::get_instance()) ? '✅' : '❌';
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
     * Renderiza el panel de información en la administración.
     */
    public static function render_diagnostic_panel(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $engine  = Engine::get_instance();

        $is_test_mode = (isset($_GET['test_forge']) ? sanitize_key($_GET['test_forge']) : '') === '1';

        if (!$is_test_mode) {
            return;
        }

        // VALIDACIÓN CENTRALIZADA: Usamos el token del Engine
        $token = $engine->get_token();

        if (
            !isset($_GET['_wpnonce'])
            ||
            !wp_verify_nonce($_GET['_wpnonce'], 'poeticsoft_heart_token')
        ) {
            
            wp_die(__('Seguridad fallida: Token inválido', 'poeticsoft-heart'));
        }

        $report      = self::run_diagnostic();
        $refresh_url = admin_url('?test_forge=1&_wpnonce=' . $token);

        ?>
        <div class="notice notice-info" style="padding: 20px; border-left-color: #722ed1;">
            <h2 style="margin-top:0;">🛡️ <?php esc_html_e('Informe Heart & Forge', 'poeticsoft-heart'); ?></h2>
            
            <ul style="
                list-style:none; 
                font-size:1.1em; 
                background:#f0f0f1; 
                padding:15px; 
                border-radius:4px; 
                border:1px solid #dcdcde;
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
                <a href="<?php echo esc_url(admin_url()); ?>" class="button">
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
     * Añade el enlace de "Diagnóstico" en la tabla de plugins.
     */
    public static function add_action_link(array $links): array
    {
        
    $engine  = Engine::get_instance();
        
        // Usamos el Master Nonce para construir la URL manualmente
        $token = $engine->get_token();
        
        $url   = admin_url('?test_forge=1&_wpnonce=' . $token);

        $link = sprintf(
            '<a href="%s" style="font-weight:bold; color:#722ed1;">%s</a>',
            esc_url($url),
            esc_html__('Diagnóstico', 'poeticsoft-heart')
        );

        array_unshift($links, $link);
        return $links;
    }
}