<?php

namespace Poeticsoft\Heart\UI;

use Poeticsoft\Heart\UI\Main as UI;

class Blocks
{
    private $heart;
    private $ui;

    public function __construct(UI $ui)
    {
        $this->ui = $ui;
        $this->heart = $ui->heart;

        $this->register_common();
        $this->register_blocks();
    }

    private function register_common()
    {

        add_action(
            'enqueue_block_assets',
            function () {

                wp_enqueue_style('dashicons');
            }
        );
    }

    private function register_blocks()
    {

        add_action(
            'init',
            function () {

                add_filter(
                    'block_categories_all',
                    function (
                        $categories,
                        $post
                    ) {

                        $forges = $this->heart->forge->get_forges();
                        foreach ($forges as $forge_id => $forge) {
                            if ($forge->get_has_ui_blocks()) {
                                $forge_name = $forge->get_name();

                                $posticsoft_heart_category = [
                                    'slug'  => 'poeticsoft-' . $forge_id,
                                    'title' => 'Poeticsoft ' . $forge_name
                                ];

                                array_unshift($categories, $posticsoft_heart_category);

                                /**
                                 * DEBUG
                                 */
                                // Heart::log('---------------------------------------------');
                                // Heart::log('CATEGORY');
                                // Heart::log($posticsoft_heart_category);
                            }
                        }

                        return $categories;
                    },
                    10,
                    2
                );

                $forges = $this->heart->forge->get_forges();
                foreach ($forges as $forge_id => $forge) {
                    if ($forge->get_has_ui_blocks()) {
                        $forge_path = $forge->get_plugin_path();
                        $blocks_path = $forge_path . '/block';
                        $block_names = array_diff(
                            scandir($blocks_path),
                            ['..', '.']
                        );

                        $this->heart->forge->get_forges();

                        foreach ($block_names as $key => $block_name) {
                            $block_json_dir = $blocks_path . '/' . $block_name;

                            $registered = register_block_type($block_json_dir);

                            /**
                             * DEBUG
                             */
                            // $forge_name = $forge->get_name();
                            // $this->heart->logging->log('---------------------------------------------');
                            // $this->heart->logging->log(
                            //     'registered block ' .
                            //     $block_name .
                            //     ' en ' .
                            //     'Poeticsoft ' . $forge_name .
                            //     ' -> ' .
                            //     ( $registered ? 'SI' : 'NO')
                            // );
                        }
                    }
                }
            }
        );
    }
}
