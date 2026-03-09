<?php

namespace Poeticsoft\Heart\Forge;

abstract class BlockControlTemplate
{
    protected $forge;
    protected $block_control;
    
    public $block_name;
    public $block_attributes;

    public function __construct($forge, $parent)
    {
        $this->forge = $forge;
        $this->block_control = $parent;
        
        $this->block_name = $this->get_block_name();
        $this->block_attributes = $this->get_block_attributes();
        
        $this->init();
    }

    abstract public function get_block_name();
    abstract public function get_block_attributes();

    protected function init()
    {
    }
}
