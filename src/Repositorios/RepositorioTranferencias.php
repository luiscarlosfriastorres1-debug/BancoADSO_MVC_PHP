<?php

namespace App\Repositorios;

use App\Modelos\Tranferencia;
use App\Nucleo\Conexion;
use PDO;

class RepositorioTranferencias
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::obtener();
    }

    public function registrar(int $origenId, int $destinoId, string $valor): void
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO transferencias (cuenta_origen_id, cuenta_destino_id, valor)
             VALUES (:origen, :destino, :valor)'
        );
        $stmt->execute(['origen' => $origenId, 'destino' => $destinoId, 'valor' => $valor]);
    }

    public function listarEnviadasPorCuenta(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT t.id, t.cuenta_origen_id, t.cuenta_destino_id, t.valor, t.fecha,
                    c.numero_cuenta AS numero_cuenta_destino
             FROM transferencias t
             INNER JOIN cuentas c ON c.id = t.cuenta_destino_id
             WHERE t.cuenta_origen_id = :cuenta_id
             ORDER BY t.fecha DESC, t.id DESC'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);

        return array_map(
            fn (array $f) => new Tranferencia(
                (int) $f['id'],
                (int) $f['cuenta_origen_id'],
                (int) $f['cuenta_destino_id'],
                (string) $f['valor'],
                (string) $f['fecha'],
                (string) $f['numero_cuenta_destino']
            ),
            $stmt->fetchAll()
        );
    }

    public function resumenEnviadasPorCuenta(int $cuentaId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT COUNT(*) AS cantidad, COALESCE(SUM(valor), 0) AS total
             FROM transferencias WHERE cuenta_origen_id = :cuenta_id'
        );
        $stmt->execute(['cuenta_id' => $cuentaId]);
        $fila = $stmt->fetch();

        return ['cantidad' => (int) $fila['cantidad'], 'total' => (string) $fila['total']];
    }
}


?>