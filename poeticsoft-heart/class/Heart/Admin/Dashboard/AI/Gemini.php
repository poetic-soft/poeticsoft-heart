<?php

namespace Poeticsoft\Heart\Admin\Dashboard\AI;

use Poeticsoft\Heart\Template\Dashboard as DashboardTemplate;

class Gemini extends DashboardTemplate
{
    public function set_values()
    {

        $this->id = 'gemini';
        $this->title = 'Gemini AI';
        $this->description = 'Dashboard para la administracion del AI Agente Gemini';

        $this->options = [
            [
                'key' => 'url',
                'field_type' => 'string',
                'title' => 'Url Gemini',
                'description' => 'Url Gemini',
                'value' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
                'type' => 'text'
            ],
            [
                'key' => 'key',
                'field_type' => 'string',
                'title' => 'Gemini API Key',
                'description' => 'Gemini API Key',
                'value' => '',
                'type' => 'text'
            ]
        ];
    }
}
