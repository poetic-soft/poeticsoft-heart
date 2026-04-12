<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\API\Main as API;

class WhiteList
{
    protected $api;
    protected $heart;
    protected $local;
    protected $whitelist;
    protected $whitelist_compiled;

    public function __construct(API $api)
    {
        $this->api = $api;
        $this->heart = $api->heart;
        $this->local = $api->local;
        $this->whitelist = [
            'public' => [],
            'logged' => []
        ];
        $this->whitelist_compiled = [
            'public' => '',
            'logged' => ''
        ];
    }

    public function get_compiled(string $type): string
    {
        // Si no se ha compilado, lo hacemos ahora (Lazy loading controlado)
        if (empty($this->whitelist_compiled['public']) && empty($this->whitelist_compiled['logged'])) {
            $this->compile_whitelists();
        }

        return $this->whitelist_compiled[$type] ?? '/^$/';
    }

    public function compile_whitelists()
    {

        $whitelists = $this->local->get_whitelist();

        $namespace = str_replace('-', '/', $this->heart->get_id()); // TO DO Function format namespace

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

        $forges = $this->heart->forge->get_forges();

        foreach ($forges as $forge) {
            if ($forge->get_has_api()) {
                $forge_api = $forge->get_api();
                $whitelists = $forge_api->get_whitelist();

                $namespace = str_replace('-', '/', $this->heart->get_id()) .
                    '/' .
                    str_replace('-', '/', $forge->get_id());

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

        foreach ($this->whitelist as $type => $endpoints) {
            if (empty($endpoints)) {
                $this->whitelist_compiled[$type] = '/^$/';

                continue;
            }

            $type_regex_parts = array_map(
                function ($endpoint) {

                    $quoted = str_replace('/', '\/', $endpoint);

                    $pattern = str_replace('*', '.*', $quoted);

                    return $pattern . '(\?.*)?';
                },
                $endpoints
            );

            $this->whitelist_compiled[$type] = '/^(' . implode('|', $type_regex_parts) . ')$/';
        }
    }
}
