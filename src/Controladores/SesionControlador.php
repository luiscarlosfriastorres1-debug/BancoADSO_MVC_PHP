<?php

namespace App\Controladores;

use App\Excepciones\CredencialesInvalidasException;
use App\Nucleo\ControladorBase;
use App\Servicios\ServicioAutenticacion;

class SesionControlador extends ControladorBase
{
    private ServicioAutenticacion $autenticacion;

    public function __construct()
    {
        parent::__construct();
        $this->autenticacion = new ServicioAutenticacion();
    }

    protected function requiereSesion(): bool
    {
        return false;
    }

    public function loginAccion(): void
    {
        if (isset($_SESSION['cuenta_id'])) {
            $this->redirigir('cuenta');
        }

        $this->vista('login', ['titulo' => 'Ingresar', 'error' => null, 'numeroCuenta' => '']);
    }

    public function ingresarAccion(): void
    {
        if (!$this->esPost()) {
            $this->redirigir('sesion/login');
        }

        $numeroCuenta = $this->entrada('numero_cuenta');
        $clave        = $this->entrada('clave', false);

        try {
            $cuenta = $this->autenticacion->iniciar($numeroCuenta, $clave);
        } catch (CredencialesInvalidasException $e) {
            $this->vista('login', ['titulo' => 'Ingresar', 'error' => $e->getMessage(), 'numeroCuenta' => $numeroCuenta]);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['cuenta_id'] = $cuenta->getId();

        $this->redirigir('cuenta');
    }

    public function salirAccion(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }

        session_destroy();
        $this->redirigir('sesion/login');
    }
}
