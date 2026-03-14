<?php

namespace Poeticsoft\Heart\Admin\Dashboard;

use Poeticsoft\Heart\Forge\DashboardTemplate;

class Base extends DashboardTemplate
{
    public function set_values()
    {

        $this->id = 'base-heart';
        $this->title = 'Base heart';
        $this->description = 'Dashboard Heart Base';

        $this->options = [
            [
                'key' => 'string_a',
                'field_type' => 'string',
                'title' => 'Base String A',
                'description' => 'Option Base String A',
                'value' => 'default',
                'type' => 'text'
            ],
            [
                'key' => 'string_b',
                'field_type' => 'string',
                'title' => 'Base String B',
                'description' => 'Option Base String B',
                'value' => 'default',
                'type' => 'text'
            ]
        ];
    }
}
