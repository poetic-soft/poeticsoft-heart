<?php

namespace Poeticsoft\Heart\Admin\Dashboard\Tools;

use Poeticsoft\Heart\Admin\Dashboard\Tools\SectionsOptions;

class Main
{
    public $dashboard;

    private $dashboard_widgets;

    public function __construct($dashboard)
    {
        $this->dashboard = $dashboard;

        $this->dashboard_widgets = [
            new SectionsOptions($this)
        ];
    }

    public function get_dashboard_widgets()
    {

        return $this->dashboard_widgets;
    }
}
