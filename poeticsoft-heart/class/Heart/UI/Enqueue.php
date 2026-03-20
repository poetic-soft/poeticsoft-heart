<?php

namespace Poeticsoft\Heart\UI;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\UI\Main as UI;

class Enqueue
{
    private $heart;
    private $ui;

    public function __construct(UI $ui)
    {
        $this->ui = $ui;
        $this->heart = $ui->heart;

        $this->enqueue_ui();
    }

    private function enqueue($section, $forge = null)
    {

        $heart_id = $this->heart->get_id();

        $id = $heart_id;
        $path = $this->heart->get_path();
        $url = $this->heart->get_url();

        if ($forge) {

            $id .= $forge->get_id();
            $path = $forge->get_plugin_path();
            $url = $forge->get_plugin_url();
        } else {

            $path = $this->heart->get_path();
            $url = $this->heart->get_url();
        }

        $enqueue_id = $id . '-' . $section;

        $deps = [
            'blockcontrol' => [
                'wp-blocks',
                'wp-block-editor',
                'wp-element',
                'wp-components',
                'wp-data',
                'wp-compose',
                'wp-hooks',
                'lodash'
            ],
            'common' => [
                'wp-blocks',
                'wp-block-editor',
                'wp-element',
                'wp-components',
                'wp-data',
                'wp-hooks',
                'lodash'
            ],
            'admin' => [
                'wp-blocks',
                'wp-block-editor',
                'wp-element',
                'wp-components',
                'wp-data',
                'wp-hooks',
                'lodash'
            ],
            'frontend' => [
                'wp-element',
                'wp-components',
                'wp-data'
            ]
        ];

        /**
         * DEBUG
         */
        // Heart::log([
        //     'enqueue_id' => $enqueue_id,
        //     'url' => $url . '/ui/' . $section . '/main.js',
        //     'deps' => $deps[$section],
        //     'path' => $path . '/ui/' . $section . '/main.js'
        // ]);

        wp_enqueue_script(
            $enqueue_id,
            $url . '/ui/' . $section . '/main.js',
            $deps[$section],
            filemtime($path . '/ui/' . $section . '/main.js'),
            true
        );

        wp_enqueue_style(
            $enqueue_id,
            $url . '/ui/' . $section . '/main.css',
            [],
            filemtime($path . '/ui/' . $section . '/main.css'),
            'all'
        );
    }

    private function enqueue_ui()
    {

        add_action(
            'admin_enqueue_scripts',
            function () {

                $this->enqueue('common');

                $this->enqueue('admin');

                $forges = $this->heart->forge->get_forges();
                foreach ($forges as $forge_id => $forge) {

                    if ($forge->get_has_ui_admin()) {

                        $this->enqueue('admin', $forge);
                    }

                    if ($forge->get_has_ui_block_control()) {

                        $this->enqueue('blockcontrol', $forge);
                    }
                }
            }
        );

        add_action(
            'wp_enqueue_scripts',
            function () {

                $this->enqueue('frontend');

                $forges = $this->heart->forge->get_forges();
                foreach ($forges as $forge_id => $forge) {

                    if ($forge->get_has_ui_frontend()) {

                        $this->enqueue('frontend', $forge);
                    }
                }
            }
        );
    }
}
