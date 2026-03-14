<?php

namespace Poeticsoft\Heart\AIAgent;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\AIAgent\Gemini;

/**
 * Orquestador central de Agentes de IA para Poeticsoft Heart.
 * * Gestiona las instancias de los diferentes proveedores de IA
 * (Gemini, OpenAI, etc.) disponibles en el ecosistema.
 *
 * @package Poeticsoft\Heart\AIAgent
 * @since 0.0.0
 */
class Main
{
    /**
     * Instancia principal del core.
     * @var Heart
     */
    public $heart;

    /**
     * Instancia del agente Gemini.
     * @var Gemini|null
     */
    public $gemini;

    /**
     * Constructor del orquestador de agentes.
     *
     * @param Heart $heart Referencia al core del sistema.
     */
    public function __construct(Heart $heart)
    {
        $this->heart = $heart;

        // Inicializamos Gemini como primer proveedor disponible
        $this->gemini = new Gemini($this);
    }

    /**
     * Método para obtener un agente específico por su identificador.
     *
     * @param string $provider Nombre del proveedor (ej: 'gemini').
     * @return mixed Instancia del agente o null si no existe.
     */
    public function get_agent(string $provider)
    {
        return $this->$provider ?? null;
    }
}
