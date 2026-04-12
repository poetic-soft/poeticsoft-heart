<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\API\Main as API;

class Endpoints
{
    protected $api;
    protected $heart;

    public function __construct(API $api)
    {
        $this->api = $api;
        $this->heart = $api->heart;

        add_action(
            'rest_api_init',
            [
                $this,
                'register_endpoints'
            ]
        );
    }

    public function register_heart_endpoints()
    {

        $namespace = str_replace('-', '/', $this->heart->get_id());
        $endpoints = $this->api->local->get_endpoints();

        foreach ($endpoints as $version => $sections) {
            foreach ($sections as $section => $routes) {
                foreach ($routes as $route) {
                    $path = $version .
                        '/' .
                        $section .
                        '/' .
                        $route['path'];

                    // Heart::log($namespace);
                    // Heart::log($path);

                    register_rest_route(
                        $namespace,
                        $path,
                        [
                            'methods'  => $route['methods'],
                            'callback' => $route['callback'],
                            'permission_callback' => '__return_true'
                        ]
                    );
                }
            }
        }
    }

    public function register_forge_endpoints()
    {

        $forges = $this->heart->forge->get_forges();

        foreach ($forges as $forge) {
            if ($forge->get_has_api()) {
                $forge_api = $forge->get_api();

                $namespace = str_replace('-', '/', $this->heart->get_id()) .
                    '/' .
                    str_replace('-', '/', $forge->get_id());

                $endpoints = $forge_api->get_endpoints();

                foreach ($endpoints as $version => $sections) {
                    foreach ($sections as $section => $routes) {
                        foreach ($routes as $route) {
                            $path = $version .
                                '/' .
                                $section .
                                '/' .
                                $route['path'];

                            // Heart::log($namespace);
                            // Heart::log($path);

                            register_rest_route(
                                $namespace,
                                $path,
                                [
                                    'methods'  => $route['methods'],
                                    'callback' => $route['callback'],
                                    'permission_callback' => '__return_true'
                                ]
                            );
                        }
                    }
                }
            }
        }
    }

    public function register_endpoints()
    {

        $this->register_heart_endpoints();

        $this->register_forge_endpoints();
    }
}
