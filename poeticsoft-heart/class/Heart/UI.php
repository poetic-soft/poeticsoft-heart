<?php

namespace Poeticsoft\Heart;

use Poeticsoft\Heart as Heart;

/**
 * Clase UI - procesos relacionados son inteface de usuario
 *
 * Carga recursos para Administracion y Visualización Frontend
 * de tods los Forges!
 *
 * @package Poeticsoft\UI
 * @since 0.0.0
 */
class UI
{
    /**
     * Instancia del motor principal.
     *
     * @var Engine
     */
    private $engine;

    /**
     * Constructor de la clase UI.
     *
     * @param Engine $heart Inyección de la instancia del motor.
     */
    public function __construct(Engine $engine)
    {
        // Heart
        $this->engine = $engine;
    }
    
    /**
     * Registra la categoria y elementos comunes para todos los bloques
     *
     * @since 0.0.0
     */
    private function forges_register_blocks_common()
    {

        add_action(
            'enqueue_block_assets',
            function () {
                
                wp_enqueue_style('dashicons');
            }
        );
    }
    
    /**
     * Crea categoria de bloques para cada forge y registra los bloques en ella
     *
     * @since 0.0.0
     */
    private function forges_register_blocks()
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
                
                        $forges = $this->engine->get_forges();
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
                
                $forges = $this->engine->get_forges();
                foreach ($forges as $forge_id => $forge) {
                    
                    if ($forge->get_has_ui_blocks()) {
                        
                        $forge_path = $forge->get_plugin_path();
                        $blocks_path = $forge_path . '/block';
                        $block_names = array_diff(
                            scandir($blocks_path),
                            ['..', '.']
                        );
                        
                        $this->engine->get_forges();
                        
                        $forge->data['blocks'] = [];
                       
                        foreach ($block_names as $key => $block_name) {

                            $block_json_dir = $blocks_path . '/' . $block_name;
                            
                            $registered = register_block_type($block_json_dir);
                            
                            if ($registered) {
                                
                                $forge->data['blocks'][] = $block_name;
                            }
                            
                            /**
                             * DEBUG
                             */
                            // $forge_name = $forge->get_name();
                            // $this->engine->logging->log('---------------------------------------------');
                            // $this->engine->logging->log(
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
    
    /**
     * Carga los assets (scripts & styles) del los ui de admin cada forge
     *
     * @since 0.0.0
     */
    
    private function forges_enqueue_ui($forge, $section)
    {
        
        $heart_id = $this->engine->get_id();
        $forge_id = $forge->get_id();
        $enqueue_id = $heart_id . '-' . $forge_id . '-' . $section;
        $forge_path = $forge->get_plugin_path();
        $forge_uri = $forge->get_plugin_uri();
        
        $deps = [
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
        // $this->engine->logging->log([
        //     'enqueue_id' => $enqueue_id,
        //     'uri' => $forge_uri . '/ui/' . $section . '/main.js',
        //     'deps' => $deps[$section],
        //     'path' => $forge_path . '/ui/' . $section . '/main.js'
        // ]);
    
        wp_enqueue_script(
            $enqueue_id,
            $forge_uri . '/ui/' . $section . '/main.js',
            $deps[$section],
            filemtime($forge_path . '/ui/' . $section . '/main.js'),
            true
        );
    
        wp_enqueue_style(
            $enqueue_id,
            $forge_uri . '/ui/' . $section . '/main.css',
            [],
            filemtime($forge_path . '/ui/' . $section . '/main.css'),
            'all'
        );
    }
    
    /**
     * Carga los assets (scripts & styles) del los ui de admin cada forge
     *
     * @since 0.0.0
     */
    
    private function forges_enqueue_ui_admin()
    {
        
        add_action(
            'admin_enqueue_scripts',
            function () {
                
                $forges = $this->engine->get_forges();
                foreach ($forges as $forge_id => $forge) {
                    
                    if ($forge->get_has_ui_admin()) {
                        
                        $this->forges_enqueue_ui($forge, 'admin');
                    }
                }
            }
        );
    }
    
    /**
     * Carga los assets (scripts & styles) del los ui frontend de cada forge
     *
     * @since 0.0.0
     */
    private function forges_enqueue_ui_frontend()
    {
        
        add_action(
            'wp_enqueue_scripts',
            function () {
                
                $forges = $this->engine->get_forges();
                foreach ($forges as $forge_id => $forge) {
                    
                    if ($forge->get_has_ui_frontend()) {
                        
                        $this->forges_enqueue_ui($forge, 'frontend');
                    }
                }
            }
        );
    }
    
    /**
     * Registra custom renders para core blocks
     *
     * @since 0.0.0
     */
    private function forges_register_core_blocks_render()
    {
        
        $forges = $this->engine->get_forges();
        foreach ($forges as $forge_id => $forge) {
            
            if ($forge->get_has_ui_core_blocks()) {
                
                $forge_core_block = $forge->get_core_block();
                $forge_core_blocks = $forge_core_block->get_core_blocks();
                
                foreach ($forge_core_blocks as $block_name => $forge_core_block) {
                    
                    $block_render = 'render_block_' . $block_name;
                    
                    add_filter(
                        $block_render,
                        [$forge_core_block, 'render'],
                        10,
                        2
                    );
                }
            }
        }
    }
    
    /**
     * Registra los metaboxes de los forges
     *
     * @since 0.0.0
     */
    private function forges_add_ui_meta_boxes()
    {
        
        add_action(
            'add_meta_boxes',
            function () {
                
                $forges = $this->engine->get_forges();
                foreach ($forges as $forge_id => $forge) {
                    
                    if ($forge->get_has_ui_meta_boxes()) {
                        
                        $forge_meta_box = $forge->get_meta_box();
                        $forge_meta_boxes = $forge_meta_box->get_meta_boxes();
                        
                        foreach ($forge_meta_boxes as $forge_meta_box) {
                                                    
                            add_meta_box(
                                $forge_meta_box->id,
                                $forge_meta_box->title,
                                [$forge_meta_box, 'callback'],
                                $forge_meta_box->screen,
                                $forge_meta_box->context,
                                $forge_meta_box->priority,
                                $forge_meta_box->callback_args,
                            );
                        }
                    }
                }
            }
        );
    }
    
    /**
     * Lanza los procesos de carga para
     * - languages
     * - assets
     * - blocks
     * - coreblocks
     *
     * @since 0.0.0
     */
    public function init()
    {
        
        // Languages
        add_action(
            'init',
            function () {
        
                load_plugin_textdomain(
                    'poeticsoft-heart',
                    false,
                    dirname($this->engine->get_basename()) . '/languages'
                );
            }
        );
        
        // // Elementos comunes de los blocks (categoria, iconos, etc)
        $this->forges_register_blocks_common();
        
        // // Registor de los blocks
        $this->forges_register_blocks();
        
        // Assets del admin (Scripts & Styles)
        $this->forges_enqueue_ui_admin();
        
        // Assets del frontend (Scripts & Styles)
        $this->forges_enqueue_ui_frontend();
        
        // Metaboxes
        $this->forges_add_ui_meta_boxes();
    }
    
    public function register_forges_parts()
    {
                
        // Render de core blocks after forges init
        $this->forges_register_core_blocks_render();
    }
}
