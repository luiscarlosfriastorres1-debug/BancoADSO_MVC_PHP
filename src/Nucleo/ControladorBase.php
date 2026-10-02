<?php

namespace App\Nucleo;

abstract class ControladorBase
{
    public function __construct()
    {
        if ($this->requiereSesion() && !isset($_SESSION['cuenta_id'])) {
            $this->redirigir('sesion/login');
        }
    }

    protected function requiereSesion(): bool
    {
        return true;
    }

    protected function cuentaActivaId(): int
    {
        return (int) $_SESSION['cuenta_id'];
    }

    protected function vista(string $nombre, array $datos = []): void
    {
        $datos['autenticado'] = isset($_SESSION['cuenta_id']);
        $datos['aviso']       = $this->tomarAviso();

        (new Vista())->render($nombre, $datos);
    }

    protected function redirigir(string $ruta): void
    {
        header('Location: index.php?ruta=' . $ruta);
        exit;
    }

    protected function avisar(string $tipo, string $texto): void
    {
        $_SESSION['aviso'] = ['tipo' => $tipo, 'texto' => $texto];
    }

    private function tomarAviso(): ?array
    {
        $aviso = $_SESSION['aviso'] ?? null;
        unset($_SESSION['aviso']);

        return $aviso;
    }

    protected function entrada(string $campo, bool $recortar = true): string
    {
        $valor = $_POST[$campo] ?? '';
        if (!is_string($valor)) {
            return '';
        }

        return $recortar ? trim($valor) : $valor;
    }

    protected function esPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST';
    }
}
