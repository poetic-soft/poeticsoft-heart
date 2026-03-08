<?php

namespace Poeticsoft\Heart\Admin\Dashboard;

use Poeticsoft\Heart\Admin\Dashboard\Main as Dashboard;

class Forges
{
    private $dashboard;
    private $heart;
    
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
        $this->heart = $dashboard->admin->heart;
    }
}
