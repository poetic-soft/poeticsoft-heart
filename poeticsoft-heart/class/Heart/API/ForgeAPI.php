<?php

namespace Poeticsoft\Heart\API;

use Poeticsoft\Heart\Engine;
use Poeticsoft\Heart\ForgeInterface;

/**
 * Plantilla para la API de cada forge
 * Se ampliará con funcionalidades extra si es necesario
 * evitando modificar la api de cada forge que sólo se dedica a codificar endpoints
 *
 * @since 0.0.0
 */
abstract class ForgeAPI
{
    protected $forge;
    protected $engine;

    public function __construct(
        ForgeInterface $forge,
        Engine $engine
    ) {
        
        $this->forge = $forge;
        $this->engine = $engine;
    }

    /**
     * Debe retornar el array de configuración de endpoints.
     */
    abstract public function get_endpoints(): array;
    
    /**
     * Test de funcion añadida
     */
    
    public function test_auxiliar()
    {
        
        $this->engine->logging->log('AUXILIAR');
    }
}
