<?php

namespace Poeticsoft\Heart\Forge;

abstract class DashboardTemplate
{
    public $dashboard;
    public $heart;
    public $forge;
    
    public $id;
    public $title;
    public $description;
    public $args = [['test' => 'value']];
    public $context = 'normal'; // 'normal', 'side', 'column3', or 'column4'. Default 'normal'
    public $priority = 'core'; // 'high', 'core', 'default', or 'low'. Default 'core'.
    public $options;

    public function __construct($parent, $heart, $forge = null)
    {
        $this->dashboard = $parent;
        $this->heart = $heart;
        $this->forge = $forge;
        
        $this->set_values();
    }

    abstract public function set_values();
    
    public function content($uno, $args)
    {
        
        $full_id = str_replace(
            '-',
            '_',
            $this->heart->get_id() .
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
            $this->options
        );
        
        echo '<div class="DashboardWidgetContent">
            <script>
                const 
                json_encode($options, JSON_PRETTY_PRINT) .
            </script>
        </div>';
    }
}
