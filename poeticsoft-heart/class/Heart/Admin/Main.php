<?php

namespace Poeticsoft\Heart\Admin;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\Admin\Dashboard\Main as Dashboard;
    
class Main
{
    // -------------------------------------------------------------------------------
    
    public $heart;
    public $dashboard;
    private ?string $token = null;

    // -------------------------------------------------------------------------------
    
    public function __construct(Heart $heart)
    {
        $this->heart = $heart;

        $this->dashboard = new Dashboard($this);
    }
    
    // -------------------------------------------------------------------------------
    
    public function get_token(): string
    {
        if (null === $this->token) {
            
            $this->token = wp_create_nonce('wp_rest');
        }

        return $this->token;
    }
}
