<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\API\Main as API;

class Auth
{
    protected $api;
    protected $heart;
    
    public function __construct(API $api)
    {
        $this->api = $api;
        $this->heart = $api->heart;
        
        add_filter(
            'rest_authentication_errors',
            [
                $this,
                'check_rest_authentication'
            ]
        );
    }
    
    public function check_rest_authentication($result)
    {
        
        if (!empty($result)) {
        
            return $result;
        }
        
        $request_uri = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));
        
        wp_validate_auth_cookie();
        
        if ($this->is_admin_user()) {

            return null;
        }
        
        $pattern = $this->api->whiteliwhite_list_compiled['public'];
        
        if (preg_match($pattern, $request_uri)) {
            
            return null;
        }
        
        $pattern = $this->api->white_list_compiled['logged'];
        
        if (
            is_user_logged_in()
            &&
            preg_match($pattern, $request_uri)
        ) {
            
            return null;
        }
        
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
}
