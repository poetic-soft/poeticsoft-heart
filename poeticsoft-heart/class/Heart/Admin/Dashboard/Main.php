<?php

// https://rudrastyh.com/wordpress/dashboard-widgets.html

namespace Poeticsoft\Heart\Admin\Dashboard;

use Poeticsoft\Heart\Admin\Main as Admin;
use Poeticsoft\Heart\Admin\Dashboard\Own;
use Poeticsoft\Heart\Admin\Dashboard\Forges;

class Main
{
    public $admin;
    
    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        
        add_action(
            'wp_dashboard_setup',
            [
                $this,
                'add_dashboard_widgets'
            ]
        );
    }
    
    public function add_dashboard_widgets()
    {
        
        $self_dashboards_widgets = new Own($this);
        
        $forges_dashboards_widgets = new Forges($this);
    }
}
