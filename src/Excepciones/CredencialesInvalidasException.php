<?php

namespace App\Excepciones;

use DomainException;

class CredencialesInvalidasException extends DomainException
{
    public function __construct(string $mensaje = 'Número de cuenta o contraseña incorrectos')
    {
        parent::__construct($mensaje);
    }
}
