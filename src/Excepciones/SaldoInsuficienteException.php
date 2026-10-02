<?php

namespace App\Excepciones;

use DomainException;

class SaldoInsuficienteException extends DomainException
{
    public function __construct(string $mensaje = 'Saldo insuficiente.')
    {
        parent::__construct($mensaje);
    }
}
