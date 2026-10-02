<?php

namespace App\Modelos;

class Usuario
{
    private readonly int $id;
    private readonly int $cuenta_id;
    private readonly string $clave_hash;

    public function __construct(int $id, int $cuenta_id, string $clave_hash)
    {
        $this->id = $id;
        $this->cuenta_id = $cuenta_id;
        $this->clave_hash = $clave_hash;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCuentaId(): int
    {
        return $this->cuenta_id;
    }

    public function getClaveHash(): string
    {
        return $this->clave_hash;
    }
}


?>