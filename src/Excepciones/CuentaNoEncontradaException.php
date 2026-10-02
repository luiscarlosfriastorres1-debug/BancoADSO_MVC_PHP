<?php

namespace App\Excepciones;

use DomainException;

class CuentaNoEncontradaException extends DomainException
{
    public function __construct(string $mensaje = 'La cuenta no existe.')
    {
        parent::__construct($mensaje);
    }
}
