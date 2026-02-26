<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Engine;
use stdClass;

class Main
{
    private $engine;
    private $whitelist;

    public function __construct(Engine $engine)
    {
        
        $this->engine = $engine;
        $this->whitelist = [
            'public' => [],
            'logged' => []
        ];
    }

    public function init()
    {
    
        add_action(
            'rest_api_init',
            function () {
                
                $this->engine->logging->log('rest_api_init');
                                
                $forges = $this->engine->get_forges();
                
                foreach ($forges as $forge) {
                        
                    if ($forge->get_has_api()) {
                        
                        $forge_api = $forge->get_api();
                        
                        $whitelist = $forge_api->get_whitelist();
                        
                        $this->engine->logging->log($whitelist);
                
                        $endpoints = $forge_api->get_endpoints();
                        
                        $forge->data['endpoints'] = [];
                            
                        foreach ($endpoints as $version => $sections) {
                
                            foreach ($sections as $section => $routes) {
                                    
                                foreach ($routes as $route) {
                                    
                                    $namespace = $this->engine->get_id() .
                                    '/' .
                                    $forge->get_id() .
                                    '/' .
                                    $version;
                                    
                                    $path = $section .
                                    '/' .
                                    $route['path'];
                                    
                                    $forge->data['endpoints'][] = $namespace . '/' . $path; // TO DO see in Inspector
                                    
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
        );
        
        add_filter(
            'rest_authentication_errors',
            function ($result) {
                
                return $result;

                // if (!empty($result)) {
                
                //     return $result;
                // }

                $request_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
                $request_method = sanitize_text_field(wp_unslash($_SERVER['REQUEST_METHOD']));
                
                // $request_uri = $_SERVER['REQUEST_URI'] ?? '';
                
                // foreach ($allowedpublic as $pattern) {

                //     $regex = '#^' . str_replace('\*', '.*', preg_quote($pattern, '#')) . '$#';
                //     if (preg_match($regex, $request_uri)) {

                //         return $result;

                //         break;
                //     }
                // }

                // if (is_user_logged_in()) {

                //     foreach ($allowedlogedusers as $pattern) {

                //         $regex = '#^' . str_replace('\*', '.*', preg_quote($pattern, '#')) . '$#';
                //         if (preg_match($regex, $request_uri)) {

                //         return $result;

                //         break;
                //         }
                //     }

                //     if ($this->api_isadminuser()) {

                //         return $result;
                //     }
                // }

                // return new WP_Error(
                //     'rest_cannot_access',
                //     __('REST API restricted access. Needs authentication.'),
                //     array( 'status' => 401 )
                // );
            }
        );
    }
}
