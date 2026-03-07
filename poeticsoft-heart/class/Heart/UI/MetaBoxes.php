<?php

namespace Poeticsoft\Heart\UI;

use Poeticsoft\Heart\UI\Main as UI;

class MetaBoxes
{
    private $heart;
    private $ui;

    public function __construct(UI $ui)
    {
        $this->ui = $ui;
        $this->heart = $ui->heart;
        
        $this->add();
    }
    
    private function add()
    {
        
        add_action(
            'add_meta_boxes',
            function () {
                
                $forges = $this->heart->forge->get_forges();
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
}
