<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart;
use Poeticsoft\Heart\Engine;

class Main
{
    private $engine;
    private $whitelist;
    // private $whitelistcachekeys; // For future Cache Use
    private $whitelistcompiled;
    private $is_compiled = false; // Flag para evitar dobles procesos

    public function __construct(Engine $engine)
    {
                        
        $this->engine = $engine;
        $this->whitelist = [
            'public' => [],
            'logged' => []
        ];
        // $this->whitelistcachekeys = [ // For future Cache Use
        //     'public' => '',
        //     'logged' => ''
        // ];
        $this->whitelistcompiled = [
            'public' => '',
            'logged' => ''
        ];
    }

    public function init()
    {
        
        // Registro de rutas
        add_action('rest_api_init', [$this, 'register_all_forge_endpoints']);
        
        // Filtro de autenticación
        add_filter('rest_authentication_errors', [$this, 'check_rest_authentication']);
    }
    
    /**
     * Compila las whitelists de todos los Forges registrados.
     * Se puede llamar preventivamente si los datos no están listos.
     */
    public function compile_whitelists()
    {
                
        if ($this->is_compiled) {
            
            return;
        }

        $forges = $this->engine->get_forges();

        foreach ($forges as $forge) {
            
            if ($forge->get_has_api()) {
                
                $forge_api = $forge->get_api();
                $whitelists = $forge_api->get_whitelist();
                
                $namespace = $this->engine->get_id() . '/' . $forge->get_id();

                foreach ($whitelists as $version => $sections) {
                    
                    foreach ($sections as $section => $types) {
                        
                        foreach ($types as $type => $paths) {
                            
                            foreach ($paths as $path) {
                                
                                $item = '/wp-json/' .
                                $namespace .
                                '/' .
                                $version .
                                '/' .
                                $section .
                                '/' .
                                $path;
                                
                                $this->whitelist[$type][] = $item;
                            }
                        }
                    }
                }
            }
        }

        // Compilación a Regex
        
        foreach ($this->whitelist as $type => $endpoints) {
            
            if (empty($endpoints)) {
                
                $this->whitelistcompiled[$type] = '/^$/'; // Regex que no coincide con nada
                
                continue;
            }

            $type_regex_parts = array_map(
                function ($endpoint) {
                
                    $quoted = str_replace('/', '\/', $endpoint);
                    
                    return str_replace('*', '.*', $quoted);
                },
                $endpoints
            );

            $this->whitelistcompiled[$type] = '/^(' . implode('|', $type_regex_parts) . ')$/';
        }

        $this->is_compiled = true;
    }
    
    public function register_all_forge_endpoints()
    {
        
        $this->compile_whitelists();
                        
        $forges = $this->engine->get_forges();
        
        foreach ($forges as $forge) {
                
            if ($forge->get_has_api()) {
                
                $forge_api = $forge->get_api();
                
                $namespace = $this->engine->get_id() .
                '/' .
                $forge->get_id();
                                        
                $endpoints = $forge_api->get_endpoints();
                
                $forge->data['endpoints'] = [];
                    
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
                
                            // Heart::log($endpoint);
                            
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
    
    public function check_rest_authentication($result)
    {
        
        // Heart::log('$result ---------------------------');
        // Heart::log($result);

        if (!empty($result)) {
        
            return $result;
        }
        
        // ¡CLAVE!: Si alguien consulta la seguridad antes de rest_api_init,
        // forzamos la compilación de la whitelist ahora mismo.
        if (!$this->is_compiled) {
            
            $this->compile_whitelists();
        }
        
        // Heart::log('_________________________________________________');
        // Heart::log('Whitelist Compiled');
        // Heart::log('---------------');
        // Heart::log($this->whitelistcompiled);
        
        // TODO organize whitelist by method?
        // $request_method = sanitize_text_field(wp_unslash($_SERVER['REQUEST_METHOD']));

        $request_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
        
        /**
         * Forzamos a WordPress a determinar el usuario actual si aún no lo ha hecho.
         * Esto permite que get_current_user_id() devuelva el valor correcto en este filtro.
         */
        
        wp_validate_auth_cookie();
        
        // Admin check
        
        // Heart::log('ADMIN ------------------------------------------');
        // Heart::log($request_uri);
        // Heart::log($this->is_admin_user());

        if ($this->is_admin_user()) {

            return null;
        }
        
        // Public check
        
        // Future use of Cache Redis/MemCache
        // $public_cache_key = $this->whitelistcachekeys['public'];
        // $pattern = wp_cache_get($public_cache_key);
        
        $pattern = $this->whitelistcompiled['public'];
        
        // Heart::log('PUBLIC ------------------------------------------');
        // Heart::log($request_uri);
        // Heart::log($pattern);
        // Heart::log(preg_match($pattern, $request_uri));
        
        if (preg_match($pattern, $request_uri)) {
            
            return null;
        }
        
        // Logged check
        
        // Future use of Cache Redis/MemCache
        // $logged_cache_key = $this->whitelistcachekeys['logged'];
        // $pattern = wp_cache_get($logged_cache_key);
        
        $pattern = $this->whitelistcompiled['logged'];
        
        // Heart::log('LOGGED ------------------------------------------');
        // Heart::log($request_uri);
        // Heart::log($pattern);
        // Heart::log(is_user_logged_in());
        // Heart::log(preg_match($pattern, $request_uri));
        
        if (
            is_user_logged_in()
            &&
            preg_match($pattern, $request_uri)
        ) {
            
            return null;
        }
        
        // Heart::log('ERROR ------------------------------------------');
        // Heart::log($request_uri);
        // Heart::log($this->is_admin_user());
        
        $message = __('REST API restricted access. Needs authentication.', 'poeticsoft-heart');
        
        $response = $this->format_response_data(
            $message,
            401,
            false
        );
        
        return new \WP_Error(
            'rest_forbidden',
            $message,
            $response
        );
    }
    
    private function is_admin_user()
    {
  
        return in_array(
            'administrator',
            wp_get_current_user()->roles
        );
    }
    
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
        
        $response = [
            'code' => '',       // Compliant with WP_Error response
            'message' => '',    //
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
                'version' => $this->engine->get_version()
            ]
        ];
    }
}
