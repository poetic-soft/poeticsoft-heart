<?php

namespace Poeticsoft\Heart\Admin\Dashboard\AIAgent;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\Admin\Dashboard\Main as Dashboard;
use Poeticsoft\Heart\Admin\Dashboard\AIAgent\Gemini;

class Main
{
    public $dashboard;

    private $dashboard_widgets;

    public function __construct(Dashboard $dashboard, Heart $heart)
    {
        $this->dashboard = $dashboard;

        $this->dashboard_widgets = [
            new Gemini($this, $heart)
        ];
    }

    public function get_dashboard_widgets()
    {

        return $this->dashboard_widgets;
    }
}
