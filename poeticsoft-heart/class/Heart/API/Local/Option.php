<?php

namespace Poeticsoft\Heart\API\Local;

use WP_REST_Request;
use WP_REST_Response;
use Exception;
use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\API\Main as API;

class Option
{
    protected $api;

    public function __construct(API $api)
    {
        $this->api = $api;
    }

    public function get_whitelist()
    {

        return [
            'option' => [
                'public' => [
                    'get',
                    'update'
                ],
                'logged' => []
            ]
        ];
    }

    public function get_routes()
    {

        return [
            'option' => [
                [
                    'path' => 'get',
                    'methods' => 'POST',
                    'callback' => [$this, 'api_option_get']
                ],
                [
                    'path' => 'update',
                    'methods' => 'POST',
                    'callback' => [$this, 'api_option_update']
                ]
            ]
        ];
    }

    public function api_option_get(WP_REST_Request $req)
    {

        try {

            $option_name = $req->get_param('option_name');

            $response = [
                'option_name' => $option_name,
                'option_value' => get_option($option_name, '')
            ];

            return $this->api->send_response($response);
        } catch (Exception $e) {

            return $this->api->send_response(
                $e->getMessage(),
                $e->getCode() ?: 500,
                false
            );
        }
    }

    // AIzaSyB_bPBjFNQqRl0GZC2yeJ9OO5UtzkeGFWQ

    public function api_option_update(WP_REST_Request $req)
    {

        try {

            $params = $req->get_params();

            $user_id = get_current_user_id();

            $option_name = $params['option_name'];
            $option_value = $params['option_value'];

            update_option($option_name, $option_value);

            return $this->api->send_response([
                'user_id' => $user_id
            ]);
        } catch (Exception $e) {

            return $this->api->send_response(
                $e->getMessage(),
                $e->getCode() ?: 500,
                false
            );
        }
    }
}
