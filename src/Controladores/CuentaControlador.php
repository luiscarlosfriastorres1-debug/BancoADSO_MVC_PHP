<?php

namespace App\Controladores;

use App\Nucleo\ControladorBase;
use App\Repositorios\RepositorioClientes;
use App\Repositorios\RepositorioCuentas;

class CuentaControlador extends ControladorBase
{
    private RepositorioCuentas $cuentas;
    private RepositorioClientes $clientes;

    public function __construct()
    {
        parent::__construct();
        $this->cuentas  = new RepositorioCuentas();
        $this->clientes = new RepositorioClientes();
    }

    public function indexAccion(): void
    {
        $cuenta = $this->cuentas->buscarPorId($this->cuentaActivaId());

        if ($cuenta === null) {
            $this->redirigir('sesion/salir');
        }

        $cliente = $this->clientes->buscarPorId($cuenta->getClienteID());

        $this->vista('panel', [
            'titulo'       => 'Mi cuenta',
            'titular'      => $cliente !== null ? $cliente->getNombre() : '',
            'numeroCuenta' => $cuenta->getNumeroCuenta(),
            'saldo'        => $cuenta->getSaldo(),
        ]);
    }
}


?>