<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Heart;
use Poeticsoft\Heart\ForgeInterface;

/**
 * Plantilla para la API de cada forge
 * Se ampliará con funcionalidades extra si es necesario
 * evitando modificar la api de cada forge que sólo se dedica a codificar endpoints
 *
 * @since 0.0.0
 */
abstract class ForgeAPI
{
    protected $forge;
    protected $heart;
    
    /**
     * Envía una respuesta unificada siguiendo el estándar de Poeticsoft Forge.
     * @param mixed $data Datos a enviar o mensaje de error.
     * @param int $status Código de estado HTTP.
     * @param bool $success Indica si la operación fue exitosa.
     * @return \WP_REST_Response
     */
    public function send_response(
        $data,
        int $status = 200,
        bool $success = true
    ): \WP_REST_Response {
        
        // Accedemos a la función send_response de la API central a través del Heart
        return $this->heart->api->send_response($data, $status, $success);
    }

    /**
     * Debe retornar el array de whitelist.
     */
    abstract public function get_whitelist(): array;

    /**
     * Debe retornar el array de configuración de endpoints.
     */
    abstract public function get_endpoints(): array;
    
    /**
     * Pueden incorporarse funcionalidades extras para la API de los forges
     *
     * public function extra() { }
     *
     */
}
