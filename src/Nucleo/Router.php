<?php

namespace App\Nucleo;

use Throwable;

class Router
{
    public function despachar(string $ruta): void
    {
        $segmentos = array_values(array_filter(explode('/', trim($ruta, '/')), fn ($s) => $s !== ''));

        $controlador = $segmentos[0] ?? 'cuenta';
        $accion      = $segmentos[1] ?? 'index';
        $parametros  = array_slice($segmentos, 2);

        if (!preg_match('/^[A-Za-z]+$/', $controlador) || !preg_match('/^[A-Za-z]+$/', $accion)) {
            $this->noEncontrado();
            return;
        }

        $clase  = 'App\\Controladores\\' . ucfirst($controlador) . 'Controlador';
        $metodo = $accion . 'Accion';

        if (!class_exists($clase) || !method_exists($clase, $metodo)) {
            $this->noEncontrado();
            return;
        }

        try {
            $objetoControlador = new $clase();
            $objetoControlador->$metodo(...$parametros);
        } catch (Throwable $e) {
            error_log((string) $e);
            http_response_code(500);
            $this->mostrar('errores/500', 'Error inesperado');
        }
    }

    private function noEncontrado(): void
    {
        http_response_code(404);
        $this->mostrar('errores/404', 'Página no encontrada');
    }

    private function mostrar(string $vista, string $titulo): void
    {
        (new Vista())->render($vista, [
            'titulo'      => $titulo,
            'autenticado' => isset($_SESSION['cuenta_id']),
            'aviso'       => null,
        ]);
    }
}


?>