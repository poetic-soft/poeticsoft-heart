<?php

namespace Poeticsoft\Heart\Admin\Metabox;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\Admin\Main as Admin;

class Main
{
    private $admin;
    private $heart;
    private $ui;

    public function __construct(Admin $admin)
    {
        $this->admin = $admin;
        $this->heart = $admin->heart;

        add_action(
            'add_metaboxes',
            [$this, 'add_metaboxes']
        );
    }

    private function add_metaboxes()
    {

        $forges = $this->heart->forge->get_forges();
        foreach ($forges as $forge_id => $forge) {

            if ($forge->get_has_ui_metaboxes()) {

                $forge_metabox = $forge->get_metabox();
                $forge_metaboxes = $forge_metabox->get_metaboxes();

                foreach ($forge_metaboxes as $forge_metabox) {

                    add_metabox(
                        $forge_metabox->id,
                        $forge_metabox->title,
                        [$forge_metabox, 'callback'],
                        $forge_metabox->screen,
                        $forge_metabox->context,
                        $forge_metabox->priority,
                        $forge_metabox->callback_args,
                    );
                }
            }
        }
    }
}
