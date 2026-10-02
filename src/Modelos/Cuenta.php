<?php

namespace App\Modelos;

class Cuenta
{
    private readonly int $id;
    private readonly string $numero_de_cuenta;
    private readonly string $saldo;
    private readonly int $cliente_id;

    public function __construct(int $id, string $numero_de_cuenta, string $saldo, int $cliente_id)
    {
        $this->id = $id;
        $this->numero_de_cuenta = $numero_de_cuenta;
        $this->saldo = $saldo;
        $this->cliente_id = $cliente_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumeroCuenta(): string
    {
        return $this->numero_de_cuenta;
    }

    public function getSaldo(): string
    {
        return $this->saldo;
    }

    public function getClienteID(): int
    {
        return $this->cliente_id;
    }
}


?>