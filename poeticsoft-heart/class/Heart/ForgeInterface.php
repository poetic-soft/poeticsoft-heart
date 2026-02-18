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
     * Obtiene el nombre legible del módulo.
     *
     * @return string Ejemplo: "Inventory Forge"
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
}
