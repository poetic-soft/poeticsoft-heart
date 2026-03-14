<?php

namespace Poeticsoft\Heart\Forge;

use Poeticsoft\Heart\Main as Heart;
use Poeticsoft\Heart\Interface\Forge as ForgeInterface;

class Main
{
    // -------------------------------------------------------------------------------

    public $heart;
    private array $forges = [];

    // -------------------------------------------------------------------------------

    public function __construct(Heart $heart)
    {

        $this->heart = $heart;

        add_action(
            'plugins_loaded', // (Hack favicon.ico for single trig)
            [
                $this,
                'plugins_loaded'
            ]
        );
    }

    public function plugins_loaded(): void
    {

        do_action('poeticsoft_heart_register', $this);

        foreach ($this->forges as $id => $forge) {

            try {

                $forge->init($this->heart);
            } catch (\Exception $e) {

                $this->heart->log("Error al inicializar Forge {$id}: {$e->getMessage()}", 'ERROR');
            }
        }

        do_action('poeticsoft_heart_booted', $this);

        $this->heart->ui->core_blocks->register();
    }

    public function registrar_forge(string $id, ForgeInterface $instancia): bool
    {

        if (empty($id)) {
            throw new \InvalidArgumentException('El ID del módulo no puede estar vacío');
        }

        $this->forges[$id] = $instancia;

        return true;
    }

    public function get_forges(): array
    {
        return $this->forges;
    }

    public function get_forgeby_id($id): array
    {
        return $this->forges[$id];
    }
}
