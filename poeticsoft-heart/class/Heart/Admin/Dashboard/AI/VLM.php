<?php

namespace Poeticsoft\Heart\Admin\Dashboard\AI;

use Poeticsoft\Heart\Template\Dashboard as DashboardTemplate;

class VLM extends DashboardTemplate
{
    public function set_values()
    {

        $this->id = 'vlm';
        $this->title = 'VLM AI';
        $this->description = 'Dashboard para la administracion del AI Agente VLM (Image)';

        $this->options = [
            [
                'key' => 'url',
                'field_type' => 'string',
                'title' => 'Url VLM',
                'description' => 'Url VLM',
                'value' => 'https://api.vlm.run/v1',
                'type' => 'text'
            ],
            [
                'key' => 'webhook_secret',
                'field_type' => 'string',
                'title' => 'VLM Webhook Secret',
                'description' => 'Webhook Secret VLM ',
                'value' => '',
                'type' => 'text'
            ],
            [
                'key' => 'key',
                'field_type' => 'string',
                'title' => 'VLM API Key',
                'description' => 'Api Key VLM',
                'value' => '',
                'type' => 'text'
            ]
        ];
    }
}
