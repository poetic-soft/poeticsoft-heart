<?php

namespace Poeticsoft\Heart;

/**
 * Clase Admin - Gestor de la interfaz administrativa.
 *
 * Se encarga de registrar los menús, notices y hooks específicos
 * del área de administración de WordPress.
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */
class Admin
{
    /**
     * Instancia del motor principal.
     *
     * @var Engine
     */
    private $engine;

    /**
     * Constructor de la clase Admin.
     *
     * @param Engine $engine Inyección de la instancia del motor.
     */
    public function __construct(Engine $engine)
    {
        $this->engine = $engine;

        // Registramos los enlaces en la tabla de plugins (como "Diagnóstico")
        add_filter(
            'plugin_action_links_' . $this->engine->get_basename(),
            [Inspector::class, 'add_action_link']
        );

        // Hook para mostrar el panel de diagnóstico si se solicita
        add_action(
            'admin_notices',
            [Inspector::class, 'render_diagnostic_panel']
        );

        // Aquí podrías añadir más hooks administrativos
        // add_action('admin_menu', [$this, 'add_admin_menu']);
    }

    /**
     * Ejemplo de método para añadir un menú (opcional para el futuro).
     * * @return void
     */
    public function add_admin_menu()
    {
        // Lógica para add_menu_page() si fuera necesario
    }
}
