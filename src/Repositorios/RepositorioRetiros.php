<?php

namespace App\Repositorios;

use App\Modelos\Retiro;
use App\Nucleo\Conexion;
use PDO;

class RepositorioRetiros
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::obtener();
    }

    public function registrar(int $cuentaId, string $valor): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO retiros (cuenta_id, valor) VALUES (:cuenta_id, :valor)');
        $stmt->execute(['cuenta_id' => $cuentaId, 'valor' => $valor]);
    }

    public function listarPorCuenta(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, cuenta_id, valor, fecha FROM retiros
             WHERE cuenta_id = :cuenta_id ORDER BY fecha DESC, id DESC'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return array_map(
            fn (array $f) => new Retiro((int) $f['id'], (int) $f['cuenta_id'], (string) $f['valor'], (string) $f['fecha']),
            $stmt->fetchAll()
        );
    }

    public function resumenPorCuenta(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS cantidad, COALESCE(SUM(valor), 0) AS total
             FROM retiros WHERE cuenta_id = :cuenta_id'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);
        $fila = $stmt->fetch();

        return ['cantidad' => (int) $fila['cantidad'], 'total' => (string) $fila['total']];
    }
}
