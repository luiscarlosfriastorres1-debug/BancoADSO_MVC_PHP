<?php

namespace App\Modelos;

class Tranferencia
{
    private readonly int $id;
    private readonly int $cuenta_origen_id;
    private readonly int $cuenta_destino_id;
    private readonly string $valor;
    private readonly string $fecha;
    private readonly ?string $numero_cuenta_destino;

    public function __construct(int $id, int $cuenta_origen_id, int $cuenta_destino_id, string $valor, string $fecha, ?string $numero_cuenta_destino)
    {
        $this->id = $id;
        $this->cuenta_origen_id = $cuenta_origen_id;
        $this->cuenta_destino_id = $cuenta_destino_id;
        $this->valor = $valor;
        $this->fecha = $fecha;
        $this->numero_cuenta_destino = $numero_cuenta_destino;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCuentaOrigenId(): int
    {
        return $this->cuenta_origen_id;
    }

    public function getCuentaDestinoId(): int
    {
        return $this->cuenta_destino_id;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getNumeroCuentaDestino(): ?string
    {
        return $this->numero_cuenta_destino;
    }
}


?>