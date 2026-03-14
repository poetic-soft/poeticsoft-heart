<?php

namespace Poeticsoft\Heart\Template;

use WP_REST_Response;
use Poeticsoft\Heart\Heart;

/**
 * Plantilla para la API de cada forge
 * Se ampliará con funcionalidades extra si es necesario
 * evitando modificar la api de cada forge que sólo se dedica a codificar endpoints
 *
 * @since 0.0.0
 */
abstract class API
{
    protected $forge;
    protected $heart;

    public function send_response(
        $data,
        int $status = 200,
        bool $success = true
    ): WP_REST_Response {

        return $this->heart->api->send_response($data, $status, $success);
    }

    abstract public function get_whitelist(): array;

    abstract public function get_endpoints(): array;
}
