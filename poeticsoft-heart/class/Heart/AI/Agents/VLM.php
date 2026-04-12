<?php

namespace Poeticsoft\Heart\AI\Agents;

use Poeticsoft\Heart\Template\AIAgent;

class VLM extends AIAgent
{
    public function chat($params)
    {

        return "Respuesta de OpenAI con temperatura {$params['temp']}";
    }

    public function createImage($prompt)
    {

        return "url-de-la-imagen-generada.png";
    }
}
