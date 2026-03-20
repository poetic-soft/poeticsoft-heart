<?php

namespace Poeticsoft\Heart\Template;

abstract class BlockControl
{
    protected $forge;
    protected $block_control;

    public $block_name;
    public $block_attributes;

    public function __construct($forge, $block_control)
    {
        $this->forge = $forge;
        $this->block_control = $block_control;

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
