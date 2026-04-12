<?php

namespace Poeticsoft\Heart\API;

use WP_Error;
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

        $request_url = sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI']));

        // wp_validate_auth_cookie();

        if (current_user_can('manage_options')) {
            return null;
        };

        $pattern = $this->api->whitelist->get_compiled('public');

        if (preg_match($pattern, $request_url)) {
            return null;
        }

        $pattern = $this->api->whitelist->get_compiled('logged');

        if (
            is_user_logged_in()
            &&
            preg_match($pattern, $request_url)
        ) {
            return null;
        }

        $message = __('REST API restricted access. Needs authentication.', 'poeticsoft-heart');

        $response = $this->api->format_response_data(
            $message,
            401,
            false
        );

        return new WP_Error(
            'rest_forbidden',
            $message,
            $response
        );
    }
}
