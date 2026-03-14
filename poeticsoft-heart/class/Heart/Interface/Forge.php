<?php

namespace Poeticsoft\Heart\Interface;

use Poeticsoft\Heart\Main as Heart;

interface Forge
{
    // -------------------------------------------------------------------------------

    public function get_id();

    public function get_name();

    public function get_version();

    public function get_description();

    public function get_plugin_path();

    public function get_plugin_uri();

    // -------------------------------------------------------------------------------

    public function get_has_dashboard_widgets();

    public function get_has_ui_admin();

    public function get_has_ui_frontend();

    public function get_has_ui_blocks();

    public function get_has_ui_core_blocks();

    public function get_has_ui_block_control();

    public function get_has_ui_core_configs();

    public function get_has_ui_metaboxes();

    public function get_has_api();

    public function get_has_ai();

    // -------------------------------------------------------------------------------

    public function init(Heart $heart);
}
