<?php

namespace Poeticsoft\Heart\Interface;

interface AI
{
    public function set_role_prompt(string $role_prompt);

    public function add_message(string $role, string $content);

    public function set_tools(array $tools);

    public function set_response_format($format);

    public function chat();

    public function get_context();

    public function reset_context();
}
