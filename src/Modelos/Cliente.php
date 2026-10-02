<?php

namespace App\Modelos;

class Cliente
{
    private readonly int $id;
    private readonly string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->id = $id;
        $this->nombre = $nombre;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }
}
