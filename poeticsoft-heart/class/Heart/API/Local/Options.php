<?php

namespace Poeticsoft\Heart\API\Local;

use WP_REST_Request;
use WP_REST_Response;
use Exception;
use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\API\Main as API;

class Options
{
    protected $api;

    public function __construct(API $api)
    {
        $this->api = $api;
    }

    public function get_whitelist()
    {

        return [
            'options' => [
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
            'options' => [
                [
                    'path' => 'get',
                    'methods' => 'POST',
                    'callback' => [$this, 'api_options_get']
                ],
                [
                    'path' => 'update',
                    'methods' => 'POST',
                    'callback' => [$this, 'api_options_update']
                ]
            ]
        ];
    }

    public function api_options_get(WP_REST_Request $req)
    {

        $res = new WP_REST_Response();

        try {

            $params = $req->get_params();

            $options = $params['options'];

            $response = [];

            foreach ($options as $option) {

                $response[$option] = get_option($option, '');
            }

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

    public function api_options_update(WP_REST_Request $req)
    {

        $res = new WP_REST_Response();

        try {

            $params = $req->get_params();

            $user_id = get_current_user_id();

            $settings = $params['settings'];

            foreach ($settings as $key => $setting) {

                update_option($key, $setting);
            }

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
