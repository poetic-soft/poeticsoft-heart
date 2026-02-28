<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Engine;

class Main
{
    private $engine;
    private $whitelist;
    private $whitelistcachekeys;

    public function __construct(Engine $engine)
    {
                
        $this->engine = $engine;
        $this->whitelist = [
            'public' => [],
            'logged' => []
        ];
        $this->whitelistcachekeys = [
            'public' => '',
            'logged' => ''
        ];
    }

    public function init()
    {
    
        add_action(
            'rest_api_init',
            function () {
                                
                $forges = $this->engine->get_forges();
                
                foreach ($forges as $forge) {
                        
                    if ($forge->get_has_api()) {
                        
                        $forge_api = $forge->get_api();
                        
                        $namespace = $this->engine->get_id() .
                        '/' .
                        $forge->get_id();
                        
                        $whitelists = $forge_api->get_whitelist();
                        
                        foreach ($whitelists as $version => $sections) {
                
                            foreach ($sections as $section => $types) {
                                
                                foreach ($types as $type => $paths) {
                                    
                                    foreach ($paths as $path) {
                                    
                                        $item = '/wp-json/' . $namespace . '/' . $version . '/' . $section . '/' . $path;
                            
                                        $this->whitelist[$type][] = $item;
                                    }
                                }
                            }
                        }
                        
                        /**
                         * ------------------------------------------------------------------------
                         * SCHEMA
                         *
                         * {
                         *   "public": [
                         *      "\/wp-json\/poeticsoft-heart\/forge-base\/v1\/default\/status-a",
                         *      "\/wp-json\/poeticsoft-heart\/forge-base\/v1\/base\/base\/test\/a"
                         *  ],
                         *  "logged": [
                         *      "\/wp-json\/poeticsoft-heart\/forge-base\/v1\/default\/status-b",
                         *      "\/wp-json\/poeticsoft-heart\/forge-base\/v1\/base\/base\/test\/b"
                         *  ]
                         * }
                         */
                                                
                        // Cache
                        
                        foreach ($this->whitelist as $type => $endpoints) {
                            
                            $type_regex_parts = array_map(
                                function ($endpoint) {
                                    
                                    $quoted = str_replace('/', '\/', $endpoint);
                                    
                                    return str_replace('*', '.*', $quoted);
                                },
                                $endpoints
                            );
                            $cached_regex_parts = '/^(' . implode('|', $type_regex_parts) . ')$/';
                            $cachekey = 'poeticsoft_heart_whitelist_' . $type;
                            wp_cache_set($cachekey, $cached_regex_parts, 'auth', 3600);
                            
                            $this->whitelistcachekeys[$type] = $cachekey;
                        }
    
                        
                        $endpoints = $forge_api->get_endpoints();
                        
                        $forge->data['endpoints'] = [];
                        
                        // $this->engine->logging->log('------------------------------------------------');
                        // $this->engine->logging->log('endpoints');
                        // $this->engine->logging->log('---------------');
                        // $this->engine->logging->log($this->whitelistcachekeys);
                            
                        foreach ($endpoints as $version => $sections) {
                
                            foreach ($sections as $section => $routes) {
                                    
                                foreach ($routes as $route) {
                                    
                                    $path = $version .
                                    '/' .
                                    $section .
                                    '/' .
                                    $route['path'];
                                    
                                    $endpoint = $namespace . '/' . $path;
                                    $forge->data['endpoints'][] = $endpoint; // TO DO see in Inspector
                        
                                    // $this->engine->logging->log($endpoint);
                                    
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

                if (!empty($result)) {
                
                    return $result;
                }
                
                // TODO organize whitelist by method?
                // $request_method = sanitize_text_field(wp_unslash($_SERVER['REQUEST_METHOD']));

                $request_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
                
                // Public check
                
                $public_cache_key = $this->whitelistcachekeys['public'];
                $pattern = wp_cache_get($public_cache_key);
                if (preg_match($pattern, $request_uri)) {
                    
                    return $result;
                }
                
                // Logged check 
                
                $logged_cache_key = $this->whitelistcachekeys['logged'];
                $pattern = wp_cache_get($logged_cache_key);
                if (
                    is_user_logged_in()
                    && 
                    preg_match($pattern, $request_uri)
                ) {
                    
                    return $result;
                }

                if ($this->is_admin_user()) {

                    return $result;
                }
                
                $this->send_response(
                    __('REST API restricted access. Needs authentication.'),
                    401,
                    false
                );
            }
        );
    }
    
    private function is_admin_user() {
  
        return in_array(
            'administrator',  
            wp_get_current_user()->roles
        );    
    }
}
