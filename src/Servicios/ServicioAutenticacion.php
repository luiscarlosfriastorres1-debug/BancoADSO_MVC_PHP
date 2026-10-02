<?php

namespace App\Servicios;

use App\Excepciones\CredencialesInvalidasException;
use App\Modelos\Cuenta;
use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioUsuarios;

class ServicioAutenticacion
{
    private RepositorioCuentas $cuentas;
    private RepositorioUsuarios $usuarios;

    public function __construct()
    {
        $this->cuentas  = new RepositorioCuentas();
        $this->usuarios = new RepositorioUsuarios();
    }

    public function iniciar(string $numeroCuenta, string $clave): Cuenta
    {
        $cuenta = $this->cuentas->buscarPorNumero($numeroCuenta);
        if ($cuenta === null) {
            throw new CredencialesInvalidasException();
        }

        $usuario = $this->usuarios->buscarPorCuentaId($cuenta->getId());
        if ($usuario === null || !password_verify($clave, $usuario->getClaveHash())) {
            throw new CredencialesInvalidasException();
        }

        return $cuenta;
    }

    public function confirmarClave(int $cuentaId, string $clave): void
    {
        $usuario = $this->usuarios->buscarPorCuentaId($cuentaId);

        if ($usuario === null || !password_verify($clave, $usuario->getClaveHash())) {
            throw new CredencialesInvalidasException('Contraseña incorrecta. Operación cancelada.');
        }
    }
}
