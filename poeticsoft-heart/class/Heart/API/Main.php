<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Engine;

class Main
{
    private $engine;
    
    public $test = 'test rest';

    public function __construct(Engine $engine)
    {
        
        $this->engine = $engine;
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
                                            'permission_callback' => function (
                                                \WP_REST_Request $request
                                            ) use (
                                                $route
                                            ) {
                                                
                                                // Si la ruta es marcada como pública, permitimos acceso
                                                if (
                                                    isset($route['public']) 
                                                    && $route['public']
                                                ) {
                                                    return true;
                                                }
                                                
                                                // De lo contrario, validamos seguridad
                                                return $this->check_permissions($request);
                                            }
                                        ]
                                    );
                                }
                            }
                        }
                    }
                }
            }
        );
    }

    /**
     * Valida la seguridad de la petición.
     * Soporta: 
     * 1. Nonces de WP (para llamadas desde el propio sitio/JS).
     * 2. Application Passwords (nativo de WP para llamadas externas).
     * * @param \WP_REST_Request $request
     * @return bool|\WP_Error
     */
    public function check_permissions(\WP_REST_Request $request)
    {
        
        // 1. Validar si el usuario ya está autenticado (vía Cookie o Application Password)
        $user_id = get_current_user_id();

        if (!$user_id) {
            
            return new \WP_Error(
                'rest_forbidden',
                __('No tienes permisos para realizar esta acción (Autenticación requerida).', 'poeticsoft-heart'),
                ['status' => 401]
            );
        }

        // 2. Si la petición es vía AJAX/Web interna, verificamos el Nonce
        // WordPress REST API verifica el nonce automáticamente si se envía en el header 'X-WP-Nonce'
        // Pero nosotros podemos forzar la validación de nuestro token específico si es necesario
        $nonce = $request->get_header('X-WP-Nonce');
        
        if (
            $nonce 
            && 
            !wp_verify_nonce($nonce, 'wp_rest')
        ) {
            
            return new \WP_Error(
                'rest_cookie_invalid_nonce',
                __('Token de seguridad inválido.', 'poeticsoft-heart'),
                ['status' => 403]
            );
        }

        // 3. Verificación adicional de capacidades si fuera necesario
        return current_user_can('read'); 
    }
}
