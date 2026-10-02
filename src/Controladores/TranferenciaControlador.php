<?php

namespace App\Controladores;

use App\Nucleo\ControladorBase;
use App\Repositorios\RepositorioTranferencias;
use App\Servicios\ServicioCuenta;
use DomainException;

class TranferenciaControlador extends ControladorBase
{
    private ServicioCuenta $servicio;
    private RepositorioTranferencias $tranferencias;

    public function __construct()
    {
        parent::__construct();
        $this->servicio      = new ServicioCuenta();
        $this->tranferencias = new RepositorioTranferencias();
    }

    public function indexAccion(): void
    {
        $this->vista('tranferencia', ['titulo' => 'Realizar transferencia']);
    }

    public function realizarAccion(): void
    {
        if (!$this->esPost()) {
            $this->redirigir('tranferencia');
        }

        try {
            $this->servicio->transferir(
                $this->cuentaActivaId(),
                $this->entrada('numero_cuenta_destino'),
                $this->entrada('clave', false),
                $this->entrada('valor')
            );
        } catch (DomainException $e) {
            $this->avisar('error', $e->getMessage());
            $this->redirigir('tranferencia');
        }

        $this->avisar('ok', 'Transferencia realizada con éxito.');
        $this->redirigir('cuenta');
    }

    public function historialAccion(): void
    {
        $cuentaId = $this->cuentaActivaId();
        $resumen  = $this->tranferencias->resumenEnviadasPorCuenta($cuentaId);

        $this->vista('historial-tranferencia', [
            'titulo'        => 'Historial de transferencias',
            'tranferencias' => $this->tranferencias->listarEnviadasPorCuenta($cuentaId),
            'cantidad'      => $resumen['cantidad'],
            'total'         => $resumen['total'],
        ]);
    }
}
