<?php

namespace Poeticsoft\Heart;

/**
 * Clase Frontend - procesos relacionados son inteface de usuario
 *
 * Carga recursos para Administracion y Visualización Frontend
 * de tods los Forges!
 *
 * @package Poeticsoft\Frontend
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
        add_filter(
            'block_categories_all',
            function (
                $categories,
                $post
            ) {
                    
                // $this->engine->logging->log('------------------------------------');
                // $this->engine->logging->log('BLOCKS COMMON CATEGORIES');
                
                $posticsoft_heart_category = [
                    'slug'  => 'poeticsoft_heart',
                    'title' => __('Poeticsoft Heart', 'poeticsoft-heart')
                ];
                
                array_unshift($categories, $posticsoft_heart_category);
                
                error_log(json_encode($categories));

                return $categories;
            },
            100,
            2
        );

        add_action(
            'enqueue_block_assets',
            function () {
                    
                // $this->engine->logging->log('------------------------------------');
                // $this->engine->logging->log('BLOCKS COMMON BLOCK ASSETS');
                
                wp_enqueue_style('dashicons');
            }
        );
    }
    
    /**
     * Registra cada bloque de los forges
     *
     * @since 0.0.0
     */
    private function forges_register_blocks()
    {

        add_action(
            'enqueue_block_editor_assets',
            function () {
                
                // $this->engine->logging->log('------------------------------------');
                // $this->engine->logging->log('BLOCKS EDITOR ASSETS');
                // $this->engine->logging->log($this->engine->get_forges());
            
                foreach ($this->engine->get_forges() as $forge) {
                    
                    $this->engine->logging->log($forge->get_name());
                }
            }
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
                    
                // $this->engine->logging->log('------------------------------------');
                // $this->engine->logging->log('UI ADMIN FORGES');
                // $this->engine->logging->log($this->engine->get_forges());
        
                foreach ($this->engine->get_forges() as $forge) {
                                
                    // Enqueue frontend
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
                    
                $this->engine->logging->log('------------------------------------');
                $this->engine->logging->log('UI FRONTEND_FORGES');
                $this->engine->logging->log($this->engine->get_forges());
                
                $forges = $this->engine->get_forges();
        
                foreach ($forges as $forge_id => $forge) { 
                        
                    $this->engine->logging->log('------------------------------------');
                    $this->engine->logging->log($forge_id);
                    $this->engine->logging->log($forge->get_has_ui_frontend() ? 'SI' : 'NO');
                }
            }
        );
    }
    
    /**
     * Lanza los procesos de carga para los assets y blocks de los Forges
     *
     * @since 0.0.0
     */
    public function init()
    {
        
        // // Elementos comunes de los blocks (categoria, iconos, etc)
        $this->forges_register_blocks_common();
        
        // // Registor de los blocks
        $this->forges_register_blocks();
        
        // Assets del admin (Scripts & Styles)
        $this->forges_enqueue_ui_admin();
        
        // Assets del frontend (Scripts & Styles)
        $this->forges_enqueue_ui_frontend();
    }
}
