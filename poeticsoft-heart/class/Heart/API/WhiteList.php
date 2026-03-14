<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\API\Main as API;

class WhiteList
{
    protected $api;
    protected $heart;
    protected $white_list;
    protected $white_list_compiled;

    public function __construct(API $api)
    {
        $this->api = $api;
        $this->heart = $api->heart;
        $this->white_list = [
            'public' => [],
            'logged' => []
        ];
        $this->white_list_compiled = [
            'public' => '',
            'logged' => ''
        ];
    }

    public function compile_whitelists()
    {

        $forges = $this->heart->forge->get_forges();

        foreach ($forges as $forge) {

            if ($forge->get_has_api()) {

                $forge_api = $forge->get_api();
                $whitelists = $forge_api->get_whitelist();

                $namespace = $this->heart->get_id() . '/' . $forge->get_id();

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

                                $this->white_list[$type][] = $item;
                            }
                        }
                    }
                }
            }
        }

        foreach ($this->white_list as $type => $endpoints) {

            if (empty($endpoints)) {

                $this->white_list_compiled[$type] = '/^$/';

                continue;
            }

            $type_regex_parts = array_map(
                function ($endpoint) {

                    $quoted = str_replace('/', '\/', $endpoint);

                    return str_replace('*', '.*', $quoted);
                },
                $endpoints
            );

            $this->white_list_compiled[$type] = '/^(' . implode('|', $type_regex_parts) . ')$/';
        }
    }
}
