<?php

namespace Poeticsoft\Heart\Admin\Dashboard\Tools;

use Poeticsoft\Heart\Template\Dashboard as DashboardTemplate;

class SectionsOptions extends DashboardTemplate
{
    public function set_values()
    {

        $this->id = 'sections_options';
        $this->title = 'Section & Options List';
        $this->description = 'Lista de secciones y opciones registradas';
    }

    public function set_data()
    {

        $this->data = $this->dashboard_instance->dashboard->sections_options;
    }
}
