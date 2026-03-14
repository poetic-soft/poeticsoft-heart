<?php

namespace Poeticsoft\Heart\Interface;

interface AI
{
    /**
     * Establece el 'System Prompt' o instrucción base del agente.
     * Define el comportamiento y la identidad de la IA.
     *
     * @param string $role_prompt Instrucciones de comportamiento.
     */
    public function set_role_prompt(string $role_prompt): void;

    /**
     * Añade un mensaje al contexto acumulable de la conversación.
     * * @param string $role El rol del emisor (user, assistant, system).
     * @param string $content El contenido del mensaje.
     */
    public function add_message(string $role, string $content): void;

    /**
     * Define las herramientas (functions) que la IA puede invocar.
     * Útil para que la IA interactúe con el resto de plugins Forge.
     *
     * @param array $tools Esquema de funciones disponibles.
     */
    public function set_tools(array $tools): void;

    /**
     * Configura el formato de salida esperado (ej: JSON, texto plano).
     *
     * @param array|string $format Configuración del formato de respuesta.
     */
    public function set_response_format($format): void;

    /**
     * Ejecuta la petición a la API y devuelve la respuesta.
     *
     * @return mixed Respuesta procesada de la IA.
     */
    public function chat();

    /**
     * Recupera el historial completo de la conversación actual.
     *
     * @return array Lista de mensajes acumulados.
     */
    public function get_context(): array;

    /**
     * Limpia el contexto de la conversación.
     */
    public function reset_context(): void;
}
