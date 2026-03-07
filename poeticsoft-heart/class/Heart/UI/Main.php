<?php

namespace Poeticsoft\Heart\UI;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\UI\Blocks;
use Poeticsoft\Heart\UI\CoreBlocks;
use Poeticsoft\Heart\UI\Enqueue;
use Poeticsoft\Heart\UI\MetaBoxes;

class Main
{
    public $heart;
    public $blocks;
    public $core_blocks;
    public $enqueue;
    public $meta_boxes;

    public function __construct(Heart $heart)
    {
        
        $this->heart = $heart;
        
        $this->blocks = new Blocks($this);
        $this->core_blocks = new CoreBlocks($this);
        $this->enqueue = new Enqueue($this);
        $this->meta_boxes = new MetaBoxes($this);
        
        $this->init();
    }
    
    public function init()
    {
        
        add_action(
            'init',
            function () {
        
                load_plugin_textdomain(
                    'poeticsoft-heart',
                    false,
                    dirname($this->heart->get_basename()) . '/languages'
                );
            }
        );
    }
}
