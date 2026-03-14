<?php

namespace Poeticsoft\Heart\Admin;

use Poeticsoft\Heart\Admin\Main as Admin;

class Inspector
{
    private $heart;
    private $admin;

    public function __construct(Admin $admin)
    {

        $this->admin = $admin;
        $this->heart = $admin->heart;
    }

    private function run_diagnostic(): array
    {
        global $wp_version;
        $results = [];

        $results['Heart']    = class_exists('\Poeticsoft\Heart\Heart') ? '✅' : '❌';
        $results['Singleton'] = ($this->heart === Heart::get_instance()) ? '✅' : '❌';
        $results['Forges']    = '📦 ' . count($this->heart->get_forges());

        $logfile = $this->heart->get_logfile();

        if (empty($logfile)) {

            $results['Log System'] = '⚠️ Ruta no definida';
        } else {

            if (file_exists($logfile)) {
                $results['Log Status'] = is_writable($logfile) ? '✅ Escribible' : '❌ Sin permisos';
            } else {
                $results['Log Status'] = is_writable(dirname($logfile)) ? '✅ Listo para crear' : '❌ Carpeta protegida';
            }
        }

        $results['PHP'] = phpversion();
        $results['WordPress'] = $wp_version;

        return $results;
    }

    /**
     * Renderiza el panel de información en la administración.
     */
    public function render_diagnostic_panel(): void
    {

        if (!current_user_can('manage_options')) {
            return;
        }

        $is_test_mode = (isset($_GET['test_forge']) ? sanitize_key($_GET['test_forge']) : '') === '1';

        if (!$is_test_mode) {

            return;
        }

        // VALIDACIÓN CENTRALIZADA: Usamos el token del Heart
        $token = $this->heart->get_token();

        if (
            !isset($_GET['_wpnonce'])
            ||
            !wp_verify_nonce($_GET['_wpnonce'], 'wp_rest')
        ) {

            wp_die(__('Seguridad fallida: Token inválido', 'poeticsoft-heart'));
        }

        $report = $this->run_diagnostic();
        $forges = $this->heart->forge->get_forges();
        $forges = array_map(
            function ($forge) {

                return [
                    'name' => $forge->get_name(),
                    'version' => $forge->get_version(),
                    'description' => $forge->get_description(),
                    'plugin_path' => $forge->get_plugin_path(),
                    'plugin_uri' => $forge->get_plugin_uri(),
                    'has_blocks' => $forge->get_has_blocks(),
                    'has_ui_admin' => $forge->get_has_ui_admin(),
                    'has_ui_frontend' => $forge->get_has_ui_frontend(),
                    'has_api' => $forge->get_has_api(),
                    'blocks' => implode(' - ', $forge->data['blocks']),
                    'endpoints' => isset($forge->data['endpoints']) ? implode(' - ', $forge->data['endpoints']) : ''
                ];
            },
            $forges
        );
        $refresh_url = admin_url('?test_forge=1&_wpnonce=' . $token);

        ?>
        <div class="notice notice-info" style="padding: 16px; border-left-color: #722ed1;">
            <h2 style="margin-top:0;">🛡️ <?php esc_html_e('Informe Heart & Forge', 'poeticsoft-heart'); ?></h2>
            <div style="
                display: flex; 
                justify-content: space-between; 
                gap: 16px;
                margin-bottom: 16px;
            ">
                <div style="
                    flex: 1;
                    background:#f0f0f1; 
                    padding:16px; 
                    border:1px solid #dcdcde;
                ">
                    <ul style="
                        list-style:none;
                        margin: 0;
                    ">
                        <?php foreach ($report as $test => $status) : ?>
                            <li
                                style="
                                    display: block;
                                    padding-bottom: 5px;
                                    border: solid #dcdcde;
                                    border-width: 0 0 1px 0;
                                    margin-bottom: 5px;
                                ">
                                <strong><?php echo esc_html($test); ?>:</strong>
                                <span style="float: right;"><?php echo esc_html($status); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div style="
                    flex: 1;
                    background:#f0f0f1; 
                    padding:16px; 
                    border:1px solid #dcdcde;
                ">
                    <ul style="
                        list-style:none;
                        margin: 0;
                    ">
                        <?php foreach ($forges as $forge) : ?>
                            <li style="
                                padding-bottom: 5px;
                                border: solid #dcdcde;
                                border-width: 0 0 1px 0;
                                margin-bottom: 5px;
                            ">
                                <div
                                    style="
                                        padding-bottom: 5px;
                                        border: dotted #dcdcde;
                                        border-width: 0 0 1px 0;
                                        margin-bottom: 5px;
                                    ">
                                    <strong>Name:</strong>
                                    <span style="float: right;"><?php echo $forge['name']; ?></span>
                                </div>
                                <div
                                    style="
                                        padding-bottom: 5px;
                                        border: dotted #dcdcde;
                                        border-width: 0 0 1px 0;
                                        margin-bottom: 5px;
                                    ">
                                    <strong>Description:</strong>
                                    <span style="float: right;"><?php echo $forge['description']; ?></span>
                                </div>
                                <div
                                    style="
                                        padding-bottom: 5px;
                                        border: dotted #dcdcde;
                                        border-width: 0 0 1px 0;
                                        margin-bottom: 5px;
                                    ">
                                    <strong>Blocks - UI Admin - UI Frontend - API: </strong>
                                    <span style="float: right;">
                                        <?php echo $forge['has_api'] ? 'SI' : 'NO'; ?>
                                    </span>
                                    <span style="float: right;"> - </span>
                                    <span style="float: right;">
                                        <?php echo $forge['has_ui_frontend'] ? 'SI' : 'NO'; ?>
                                    </span>
                                    <span style="float: right;"> - </span>
                                    <span style="float: right;">
                                        <?php echo $forge['has_ui_admin'] ? 'SI' : 'NO'; ?>
                                    </span>
                                    <span style="float: right;"> - </span>
                                    <span style="float: right;">
                                        <?php echo $forge['has_blocks'] ? 'SI' : 'NO'; ?>
                                    </span>
                                </div>
                                <div
                                    style="
                                        padding-bottom: 5px;
                                        border: dotted #dcdcde;
                                        border-width: 0 0 1px 0;
                                        margin-bottom: 5px;
                                    ">
                                    <strong>Blocks:</strong>
                                    <span style="float: right;">
                                        <?php echo $forge['blocks']; ?>
                                    </span>
                                </div>
                                <div
                                    style="
                                        padding-bottom: 5px;
                                    ">
                                    <strong>Endpoints:</strong>
                                    <span style="float: right;">
                                        <?php echo $forge['endpoints']; ?>
                                    </span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div style="
                text-align: right;
            ">
                <a href="<?php echo esc_url(admin_url()); ?>" class="button">
                    <?php esc_html_e('Cerrar', 'poeticsoft-heart'); ?>
                </a>
                <a href="<?php echo esc_url($refresh_url); ?>" class="button button-primary">
                    <?php esc_html_e('Actualizar', 'poeticsoft-heart'); ?>
                </a>
            </div>
        </div>
<?php
    }

    /**
     * Añade el enlace de "Diagnóstico" en la tabla de plugins.
     */
    public function add_action_link(array $links): array
    {

        $heart  = Heart::get_instance();

        // Usamos el Master Nonce para construir la URL manualmente
        $token = $heart->get_token();

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
