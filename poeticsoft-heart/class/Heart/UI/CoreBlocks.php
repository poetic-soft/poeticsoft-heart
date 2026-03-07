<?php

namespace Poeticsoft\Heart\UI;

use Poeticsoft\Heart\UI\Main as UI;

class CoreBlocks
{
    private $heart;
    private $ui;

    public function __construct(UI $ui)
    {
        $this->ui = $ui;
        $this->heart = $ui->heart;
    }
    
    public function register()
    {
        
        add_action(
            'init',
            function () {
                
                $forges = $this->heart->forge->get_forges();
                foreach ($forges as $forge_id => $forge) {
                    
                    if ($forge->get_has_ui_block_control()) {
                        
                        $forge_block_control = $forge->get_block_control();
                        $forge_block_controls = $forge_block_control->get_block_controls();
                        
                        foreach ($forge_block_controls as $forge_block_control) {
                            
                            $block_type = \WP_Block_Type_Registry::get_instance()
                            ->get_registered($forge_block_control->get_block_name());
                            
                            // Heart::log('------------------------------------------');
                            // Heart::log($forge_block_control->block_name);
                            // Heart::log('--------------------');
                            // Heart::log($block_type ? 'SI' : 'NO');
                                
                            if ($block_type) {
                                
                                $block_type->attributes = array_merge(
                                    $block_type->attributes,
                                    $forge_block_control->get_block_attributes()
                                );
                            }
                        }
                    }
                }
            }
        );
        
        $forges = $this->heart->forge->get_forges();
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
}
