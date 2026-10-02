<?php

namespace App\Excepciones;

use DomainException;

class ValorInvalidoException extends DomainException
{
    public function __construct(string $mensaje = 'El valor debe ser un número mayor a 0 (solo dígitos, con punto decimal opcional).')
    {
        parent::__construct($mensaje);
    }
}
