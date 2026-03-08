<?php

namespace Poeticsoft\Heart\Admin\Dashboard;

use Poeticsoft\Heart\Admin\Dashboard\Main as Dashboard;

class Own
{
    private $dashboard;
    private $heart;
    
    public $id;
    public $title;
    public $args;
    public $context;
    public $priority;
    
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
        $this->heart = $dashboard->admin->heart;
        
        wp_add_dashboard_widget(
            'mi_widget_id',
            'Heart',
            [
                $this,
                'render'
            ],
            null,
            [
                'arg' => 'Value'
            ],
            'side',
            'core'
        );
    }
    
    public function render($post, $callback_args)
    {
        
        
        echo '<div class="Content">contenido_del_widget</div>';
    }
}
