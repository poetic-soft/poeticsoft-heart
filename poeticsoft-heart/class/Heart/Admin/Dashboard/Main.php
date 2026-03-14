<?php

// https://rudrastyh.com/wordpress/dashboard-widgets.html

namespace Poeticsoft\Heart\Admin\Dashboard;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\Admin\Main as Admin;
use Poeticsoft\Heart\Admin\Dashboard\AIAgent\Main as AIAgent;

class Main
{
    public $admin;

    private $heart;
    private $dashboards;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->heart = $this->admin->heart;

        $this->dashboards = [
            new AIAgent($this, $this->heart)
        ];

        add_action(
            'wp_dashboard_setup',
            [
                $this,
                'dashboard_setup'
            ]
        );

        add_action(
            'admin_init',
            [
                $this,
                'admin_init'
            ]
        );
    }

    // -------------------------------------------------------------------------------

    public function get_full_id($dashboard)
    {
        return str_replace(
            '-',
            '_',
            $this->admin->heart->get_id() .
                (

                    $dashboard->forge ?
                    '_' . $dashboard->forge->get_id()
                    :
                    ''
                ) .
                '_' .
                $dashboard->id
        );
    }

    // -------------------------------------------------------------------------------

    public function dashboard_setup()
    {

        foreach ($this->dashboards as $dashboard) {

            $dashboard_widgets = $dashboard->get_dashboard_widgets();

            foreach ($dashboard_widgets as $dashboard) {

                $this->add_dashboard_widget($dashboard);
            }
        }

        $forges = $this->admin->heart->forge->get_forges();

        foreach ($forges as $forge) {

            if ($forge->get_has_dashboard_widgets()) {

                $dashboards = $forge->dashboard->get_dashboard_widgets();

                foreach ($dashboards as $dashboard) {

                    $this->add_dashboard_widget($dashboard);
                }
            }
        }
    }

    public function add_dashboard_widget($dashboard)
    {

        $full_id = $this->get_full_id($dashboard);

        wp_add_dashboard_widget(
            $full_id,
            $dashboard->title,
            [
                $dashboard,
                'content'
            ],
            null,
            $dashboard->args,
            $dashboard->context,
            $dashboard->priority
        );
    }

    // -------------------------------------------------------------------------------

    public function admin_init()
    {
        foreach ($this->dashboards as $dashboard) {

            $dashboard_widgets = $dashboard->get_dashboard_widgets();

            foreach ($dashboard_widgets as $dashboard) {

                $this->create_section($dashboard);
            }
        }

        $forges = $this->admin->heart->forge->get_forges();

        foreach ($forges as $forge) {

            if ($forge->get_has_dashboard_widgets()) {

                $dashboards = $forge->dashboard->get_dashboard_widgets();

                foreach ($dashboards as $dashboard) {

                    $this->create_section($dashboard);
                }
            }
        }
    }

    // -------------------------------------------------------------------------------

    public function create_section($dashboard)
    {

        $full_id = $this->get_full_id($dashboard);

        add_settings_section(
            $full_id,
            $dashboard->title,
            function () use ($dashboard) {

                echo $dashboard->description;
            },
            'poeticsoft_heart'
        );

        foreach ($dashboard->options as $option) {

            $this->create_option(
                $option,
                $full_id
            );
        }
    }

    // -------------------------------------------------------------------------------

    public function create_option($option, $full_id)
    {

        $option_name = $full_id . '_' . $option['key'];

        $admin_option = get_option($option_name);
        if (!$admin_option) {

            update_option($option_name, $option['value']);
        }

        register_setting(
            $full_id,
            $option_name,
            [
                'type' => $option['field_type'],
                'default' => $option['value'],
                'label' => $option['title'],
                'description' => $option['description'],
                'sanitize_callback' => function ($value) {

                    return $value;
                },
                'show_in_rest' => true,
                'default' => $option['value']
            ]
        );

        add_settings_field(
            $option_name,
            '<label for="' . $option_name . '">' .
                $option['title'] .
                '</label>',
            function () use ($option_name, $option) {

                $value = get_option(
                    $option_name,
                    $option['value']
                );

                echo '<div class="Option">
                    <span class="label">' .
                    $option['title'] .
                    '</span>
                    <span class="Value">' .
                    $value .
                    '</span>
                </option>';
            },
            'poeticsoft_heart',
            $full_id
        );
    }
}
