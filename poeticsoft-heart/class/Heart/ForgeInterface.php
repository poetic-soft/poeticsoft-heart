<?php

namespace Poeticsoft\Heart;

/**
 * Contrato para los módulos (Forges) del ecosistema Poeticsoft.
 *
 * Cualquier componente que desee integrarse como un módulo dentro de Heart
 * debe implementar esta interfaz para asegurar la compatibilidad con el motor.
 *
 * @package Poeticsoft\Heart
 * @since 0.0.0
 */
interface ForgeInterface
{
    /**
     * Inicializa el módulo.
     *
     * @param Engine $engine Instancia del motor central para interactuar con el núcleo.
     * @return void
     */
    public function init(Engine $engine);

    /**
     * Obtiene el id del bloque para construccion de identificadores
     *
     * @return string Ejemplo: "forge_base"
     */
    public function get_id();

    /**
     * Obtiene el nombre legible del módulo.
     *
     * @return string Ejemplo: "Forge Base"
     */
    public function get_name();

    /**
     * Obtiene la versión actual del módulo.
     *
     * @return string Formato SemVer (ej: 1.0.2).
     */
    public function get_version();

    /**
     * Obtiene una descripción breve de la funcionalidad del módulo.
     *
     * @return string
     */
    public function get_description();

    /**
     * Obtiene el path físico del plugin
     *
     * @return string
     */
    public function get_plugin_path();

    /**
     * Obtiene la uri del plugin
     *
     * @return string
     */
    public function get_plugin_uri();

    /**
     * Flag indicador de que hay blocks para registrar
     *
     * @return boolean
     */
    public function get_has_blocks();

    /**
     * Flag indicador de assets (scripts & styles) de admin para cargar
     *
     * @return boolean
     */
    public function get_has_ui_admin();
    
    /**
     * Flag indicador de assets (scripts & styles) de frontend para cargar
     *
     * @return boolean
     */
    public function get_has_ui_frontend();
    
    /**
     * Flag indicador de que se han creado overrides de core blocks
     *
     * @return boolean
     */
    public function get_has_core_blocks();
    
    /**
     * Flag indicador de que se han creado configuradores de core blocks
     *
     * @return boolean
     */
    public function get_has_ui_core_configs();

    /**
     * Flag indicador de que hay metaboxes de edicion
     *
     * @return boolean
     */
    public function get_has_metabox();

    /**
     * Flag indicador de que declara endpoints api
     *
     * @return boolean
     */
    public function get_has_api();
}
