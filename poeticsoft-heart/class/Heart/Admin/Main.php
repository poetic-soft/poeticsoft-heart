<?php

namespace Poeticsoft\Heart\Admin;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\Admin\Dashboard\Main as Dashboard;
use Poeticsoft\Heart\Admin\Metabox\Main as Metabox;

class Main
{
    // -------------------------------------------------------------------------------

    public $heart;
    public $dashboard;
    public $metabox;
    private $create_menu = false;
    private ?string $token = null;

    // -------------------------------------------------------------------------------

    public function __construct(Heart $heart)
    {
        $this->heart = $heart;

        $this->dashboard = new Dashboard($this);
        $this->metabox = new Metabox($this);

        if (!$this->create_menu) {

            return;
        }

        add_action(
            'admin_menu',
            [
                $this,
                'create_admin_menu'
            ]
        );
    }

    // -------------------------------------------------------------------------------

    public function create_admin_menu()
    {

        add_menu_page(
            'Poeticsoft Heart',
            'Poeticsoft Heart',
            'manage_options',
            'poeticsoft_heart',
            [$this, 'render_settings'],
            'dashicons-admin-generic',
            2
        );
    }

    public function render_settings()
    {

        echo '<div class="wrap">
        <h1>Poeticsoft Heart Settings List</h1>';
        settings_fields('poeticsoft_heart');
        do_settings_sections('poeticsoft_heart');
        echo '</div>';
    }

    // -------------------------------------------------------------------------------

    public function get_token()
    {
        if (null === $this->token) {

            $this->token = wp_create_nonce('wp_rest');
        }

        return $this->token;
    }
}
