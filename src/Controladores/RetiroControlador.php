<?php

namespace App\Controladores;

use App\Nucleo\ControladorBase;
use App\Repositorios\RepositorioRetiros;
use App\Servicios\ServicioCuenta;
use DomainException;

class RetiroControlador extends ControladorBase
{
    private ServicioCuenta $servicio;
    private RepositorioRetiros $retiros;

    public function __construct()
    {
        parent::__construct();
        $this->servicio = new ServicioCuenta();
        $this->retiros  = new RepositorioRetiros();
    }

    public function indexAccion(): void
    {
        $this->vista('retiro', ['titulo' => 'Realizar retiro']);
    }

    public function realizarAccion(): void
    {
        if (!$this->esPost()) {
            $this->redirigir('retiro');
        }

        try {
            $this->servicio->retirar(
                $this->cuentaActivaId(),
                $this->entrada('clave', false),
                $this->entrada('valor')
            );
        } catch (DomainException $e) {
            $this->avisar('error', $e->getMessage());
            $this->redirigir('retiro');
        }

        $this->avisar('ok', 'Retiro realizado con éxito.');
        $this->redirigir('cuenta');
    }

    public function historialAccion(): void
    {
        $cuentaId = $this->cuentaActivaId();
        $resumen  = $this->retiros->resumenPorCuenta($cuentaId);

        $this->vista('historial-retiros', [
            'titulo'   => 'Historial de retiros',
            'retiros'  => $this->retiros->listarPorCuenta($cuentaId),
            'cantidad' => $resumen['cantidad'],
            'total'    => $resumen['total'],
        ]);
    }
}


?>