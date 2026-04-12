<?php

namespace Poeticsoft\Heart\UI;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\UI\Blocks;
use Poeticsoft\Heart\UI\CoreBlocks;
use Poeticsoft\Heart\UI\Enqueue;

class Main
{
    public $heart;
    public $blocks;
    public $core_blocks;
    public $enqueue;
    public $metaboxes;

    public function __construct(Heart $heart)
    {

        $this->heart = $heart;

        $this->blocks = new Blocks($this);
        $this->core_blocks = new CoreBlocks($this);
        $this->enqueue = new Enqueue($this);

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

        add_action(
            'admin_footer',
            function () {

                echo '<div 
                    id="poeticsoft-heart-portal-root" 
                    style="display:none;"
                ></div>';
            },
            100
        );
    }
}
