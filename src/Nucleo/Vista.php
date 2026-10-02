<?php

namespace App\Nucleo;

use RuntimeException;

class Vista
{
    private const CARPETA = __DIR__ . '/../../vistas';

    public function render(string $nombreVista, array $datos = []): void
    {
        $rutaContenido = self::CARPETA . '/' . $nombreVista . '.php';
        if (!is_file($rutaContenido)) {
            throw new RuntimeException("No existe la vista: {$nombreVista}");
        }

        extract($datos, EXTR_SKIP);

        ob_start();
        require $rutaContenido;
        $contenido = ob_get_clean();

        require self::CARPETA . '/layout.php';
    }
}


?>