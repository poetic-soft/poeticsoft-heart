<?php

namespace Poeticsoft\Heart\Template;

abstract class Dashboard
{
    public $dashboard_instance;
    public $forge;

    public $id;
    public $title;
    public $description;
    public $args = [['test' => 'value']];
    public $context = 'normal'; // 'normal', 'side', 'column3', or 'column4'. Default 'normal'
    public $priority = 'core'; // 'high', 'core', 'default', or 'low'. Default 'core'.
    public $options;
    public $data;

    public function __construct($dashboard_instance, $forge = null)
    {
        $this->dashboard_instance = $dashboard_instance;
        $this->forge = $forge;

        $this->set_values();

        add_action(
            'poeticsoft_heart_dashboard_created',
            [$this, 'set_data']
        );
    }

    abstract public function set_values();

    public function set_data() {}

    public function content()
    {

        $full_id = str_replace(
            '-',
            '_',
            $this->dashboard_instance->dashboard->admin->heart->get_id() .
                (

                    $this->forge ?
                    '_' . $this->forge->get_id()
                    :
                    ''
                ) .
                '_' .
                $this->id
        );

        $options = array_map(
            function ($option) use ($full_id) {

                $option['option_name'] = $full_id . '_' . $option['key'];

                return $option;
            },
            $this->options ? $this->options : []
        );

        echo '<div class="DashboardWidget ' . $full_id . '">
            <div id="' . $full_id . '" class="Portal">' .
            $this->description . '. Cargando editor...' .
            '</div>
            <script
                type="application/JSON"
                class="data" 
            >' .
            (
                count($options) ?
                json_encode($options, JSON_PRETTY_PRINT)
                : (
                    $this->data ?
                    json_encode($this->data, JSON_PRETTY_PRINT)
                    :
                    ''
                )
            ) .
            '</script>
            
        </div>';
    }
}
