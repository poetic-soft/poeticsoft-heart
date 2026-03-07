<?php

namespace Poeticsoft\Heart\Admin;

use Poeticsoft\Heart\Admin\Main as Admin;

class Dashboard
{
    private $heart;
    private $admin;
    
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->heart = $admin->heart;
        
        add_action(
            'wp_dashboard_setup',
            [
                $this,
                'add_dashboards_widgets'
            ]
        );
    }
    
    public function add_dashboards_widgets()
    {
        
        wp_add_dashboard_widget(
            'mi_widget_id',
            'Heart',
            [
                $this,
                'mi_widget_render'
            ]
        );
    }
    
    public function mi_widget_render()
    {
        
        echo '<div class="Content">contenido_del_widget</div>';
    }
}
