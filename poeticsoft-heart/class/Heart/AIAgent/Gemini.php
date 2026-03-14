<?php

namespace Poeticsoft\Heart\AIAgent;

use Poeticsoft\Heart\Interface\AI as AIInterface;
use Poeticsoft\Heart\AIAgent\Main as AIAgent;

/**
 * Implementación del Agente de IA utilizando la API de Google Gemini.
 *
 * Gestiona la comunicación, el envío de prompts y el formateo
 * de respuestas específicas para los modelos de Gemini.
 *
 * @package Poeticsoft\Heart\AIAgent
 * @since 0.0.0
 */
class Gemini implements AIInterface
{
    /**
     * Nodo superior de agentes.
     * @var AIAgent
     */
    protected $agent;

    /**
     * Historial de la conversación (Contexto).
     * @var array
     */
    protected $messages = [];

    /**
     * Instrucción de sistema (Role Prompt).
     * @var string
     */
    protected $role_prompt = '';

    /**
     * Formato de respuesta deseado.
     * @var mixed
     */
    protected $response_format;

    /**
     * Herramientas disponibles para el agente.
     * @var array
     */
    protected $tools = [];

    /**
     * Constructor del agente Gemini.
     *
     * @param AIAgent $agent Referencia al orquestador de agentes.
     */
    public function __construct(AIAgent $agent)
    {
        $this->agent = $agent;
    }

    /**
     * @inheritDoc
     */
    public function set_role_prompt(string $role_prompt): void
    {
        $this->role_prompt = $role_prompt;
    }

    /**
     * @inheritDoc
     */
    public function add_message(string $role, string $content): void
    {
        // Gemini usa 'user' y 'model' como roles principales
        $api_role = ($role === 'assistant') ? 'model' : $role;

        $this->messages[] = [
            'role'    => $api_role,
            'parts'   => [['text' => $content]]
        ];
    }

    /**
     * @inheritDoc
     */
    public function set_tools(array $tools): void
    {
        $this->tools = $tools;
    }

    /**
     * @inheritDoc
     */
    public function set_response_format($format): void
    {
        $this->response_format = $format;
    }

    /**
     * Ejecuta la petición REST hacia la API de Google Gemini.
     *
     * @return mixed Respuesta procesada o WP_Error en caso de fallo.
     */
    public function chat()
    {
        // Aquí iría la implementación de wp_remote_post hacia:
        // https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent

        $this->agent->heart->log('Iniciando petición a Gemini API...', 'INFO', 'AI');

        // Simulación de ejecución
        return [
            'status' => 'success',
            'content' => 'Respuesta simulada de Gemini'
        ];
    }

    /**
     * @inheritDoc
     */
    public function get_context(): array
    {
        return $this->messages;
    }

    /**
     * @inheritDoc
     */
    public function reset_context(): void
    {
        $this->messages = [];
    }
}
