<?php

namespace Poeticsoft\Heart\API\Local;

use Poeticsoft\Heart\API\Main as Api;
use Poeticsoft\Heart\Template\API as TemplateAPI;
use Poeticsoft\Heart\API\Local\Options;

class Main extends TemplateAPI
{
    protected $forge;
    protected $heart;

    protected $options;

    public function __construct($api)
    {

        $this->options = new Options($api);
    }

    public function get_whitelist(): array
    {
        return [
            'v1' => array_merge(
                $this->options->get_whitelist(),
                // $this->otra->get_whitelist()
            )
        ];
    }

    public function get_endpoints(): array
    {

        return [
            'v1' => array_merge(
                $this->options->get_routes(),
                // $this->otra->get_routes()
            )
        ];
    }
}
