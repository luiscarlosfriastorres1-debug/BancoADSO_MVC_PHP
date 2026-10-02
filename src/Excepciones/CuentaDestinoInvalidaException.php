<?php

namespace App\Excepciones;

use DomainException;

class CuentaDestinoInvalidaException extends DomainException
{
    public function __construct(string $mensaje = 'No puedes transferir a tu propia cuenta.')
    {
        parent::__construct($mensaje);
    }
}
