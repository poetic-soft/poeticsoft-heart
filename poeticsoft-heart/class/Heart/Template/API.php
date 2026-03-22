<?php

namespace Poeticsoft\Heart\Template;

abstract class API
{
    protected $forge;
    protected $heart;

    public function send_response(
        $data,
        int $status = 200,
        bool $success = true
    ) {

        return $this->heart->api->send_response($data, $status, $success);
    }

    abstract public function get_whitelist(): array;

    abstract public function get_endpoints(): array;
}
