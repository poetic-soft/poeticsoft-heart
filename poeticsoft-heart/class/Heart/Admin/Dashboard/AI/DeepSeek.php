<?php

namespace Poeticsoft\Heart\Admin\Dashboard\AI;

use Poeticsoft\Heart\Template\Dashboard as DashboardTemplate;

class DeepSeek extends DashboardTemplate
{
    public function set_values()
    {

        $this->id = 'deepseek';
        $this->title = 'DeepSeek AI';
        $this->description = 'Dashboard para la administracion del AI Agente DeepSeek';

        $this->options = [
            [
                'key' => 'url',
                'field_type' => 'string',
                'title' => 'Url DeepSeek',
                'description' => 'Url DeepSeek',
                'value' => 'https://api.deepseek.com',
                'type' => 'text'
            ],
            [
                'key' => 'key',
                'field_type' => 'string',
                'title' => 'DeepSeek API Key',
                'description' => 'Api Key DeepSeek',
                'value' => '',
                'type' => 'text'
            ]
        ];
    }
}
