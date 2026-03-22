<?php

namespace Poeticsoft\Heart\API\Local;

use Poeticsoft\Heart\API\Main as Api;
use Poeticsoft\Heart\Template\API as TemplateAPI;
use Poeticsoft\Heart\API\Local\Option;

class Main extends TemplateAPI
{
    protected $forge;
    protected $heart;

    protected $option;

    public function __construct($api)
    {

        $this->option = new Option($api);
    }

    public function get_whitelist(): array
    {
        return [
            'v1' => array_merge(
                $this->option->get_whitelist(),
                // $this->otra->get_whitelist()
            )
        ];
    }

    public function get_endpoints(): array
    {

        return [
            'v1' => array_merge(
                $this->option->get_routes(),
                // $this->otra->get_routes()
            )
        ];
    }
}
