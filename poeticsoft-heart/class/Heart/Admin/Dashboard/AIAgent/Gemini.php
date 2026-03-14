<?php

namespace Poeticsoft\Heart\Admin\Dashboard\AIAgent;

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
                'key' => 'gemini_url',
                'field_type' => 'string',
                'title' => 'Url de acceso a GL',
                'description' => 'Url de acceso a la api de Google AI Studio',
                'value' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent',
                'type' => 'text'
            ],
            [
                'key' => 'gemini_key',
                'field_type' => 'string',
                'title' => 'Gemini API Key',
                'description' => 'Api Key para la comunicacion con Google AI Studio',
                'value' => '',
                'type' => 'text'
            ]
        ];
    }
}
