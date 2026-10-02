<?php

namespace App\Repositorios;

use App\Modelos\Cliente;
use App\Nucleo\Conexion;
use PDO;

class RepositorioClientes
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::obtener();
    }

    public function buscarPorId(int $id): ?Cliente
    {
        $stmt = $this->pdo->prepare('SELECT id, nombre FROM clientes WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $fila = $stmt->fetch();

        return $fila ? new Cliente((int) $fila['id'], (string) $fila['nombre']) : null;
    }
}
