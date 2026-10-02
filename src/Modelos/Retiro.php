<?php

namespace App\Modelos;

class Retiro
{
    private readonly int $id;
    private readonly int $cuenta_id;
    private readonly string $valor;
    private readonly string $fecha;

    public function __construct(int $id, int $cuenta_id, string $valor, string $fecha)
    {
        $this->id = $id;
        $this->cuenta_id = $cuenta_id;
        $this->valor = $valor;
        $this->fecha = $fecha;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCuentaId(): int
    {
        return $this->cuenta_id;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }
}


?>