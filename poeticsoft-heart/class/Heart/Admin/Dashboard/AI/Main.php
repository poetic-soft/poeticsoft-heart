<?php

namespace Poeticsoft\Heart\Admin\Dashboard\AI;

use Poeticsoft\Heart\Admin\Dashboard\AI\DeepSeek;
use Poeticsoft\Heart\Admin\Dashboard\AI\Gemini;
use Poeticsoft\Heart\Admin\Dashboard\AI\VLM;

class Main
{
    public $dashboard;

    private $dashboard_widgets;

    public function __construct($dashboard)
    {
        $this->dashboard = $dashboard;

        $this->dashboard_widgets = [
            new DeepSeek($this),
            new Gemini($this),
            new VLM($this)
        ];
    }

    public function get_dashboard_widgets()
    {

        return $this->dashboard_widgets;
    }
}
