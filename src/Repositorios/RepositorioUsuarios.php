<?php

namespace App\Repositorios;

use App\Modelos\Usuario;
use App\Nucleo\Conexion;
use PDO;

class RepositorioUsuarios
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::obtener();
    }

    public function buscarPorCuentaId(int $cuentaId): ?Usuario
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, cuenta_id, clave_hash FROM usuarios WHERE cuenta_id = :cuenta_id'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);
        $fila = $stmt->fetch();

        return $fila
            ? new Usuario((int) $fila['id'], (int) $fila['cuenta_id'], (string) $fila['clave_hash'])
            : null;
    }
}


?>