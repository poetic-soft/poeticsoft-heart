<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\API\WhiteList;
use Poeticsoft\Heart\API\Endpoints;
use Poeticsoft\Heart\API\Auth;

class Main
{
    public $heart;
    public $white_list;
    public $endpoints;
    public $auth;

    public function __construct(Heart $heart)
    {

        $this->heart = $heart;
        $this->white_list = new WhiteList($this);
        $this->endpoints = new Endpoints($this);
        $this->auth = new Auth($this);
    }

    public function send_response(
        $data,
        int $status = 200,
        bool $success = true
    ): \WP_REST_Response {

        $response = [
            'code' => '',
            'message' => '',
            'data' => $this->format_response_data(
                $data,
                $status,
                $success
            )
        ];

        return new \WP_REST_Response($response, $status);
    }

    private function format_response_data(
        $data,
        int $status = 200,
        bool $success = true
    ) {

        $fecha = new \DateTime();
        $fecha->setTimezone(new \DateTimeZone('Europe/Madrid'));
        $fecha = $fecha->format('d/m/Y H:i:s');

        return [
            'user' => get_current_user_id(),
            'status' => $status,
            'success' => $success,
            'data' => $success ? $data : null,
            'error' => !$success ? $data : null,
            'meta' => [
                'timestampms' => time() * 1000,
                'fecha' => $fecha,
                'version' => $this->heart->get_version()
            ]
        ];
    }
}
