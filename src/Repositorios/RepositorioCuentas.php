<?php

namespace App\Repositorios;

use App\Excepciones\CuentaNoEncontradaException;
use App\Modelos\Cuenta;
use App\Nucleo\Conexion;
use PDO;

class RepositorioCuentas
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::obtener();
    }

    public function buscarPorNumero(string $numeroCuenta): ?Cuenta
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, numero_cuenta, saldo, cliente_id FROM cuentas WHERE numero_cuenta = :numero_cuenta'
        );
        $stmt->execute(['numero_cuenta' => $numeroCuenta]);

        return $this->hidratar($stmt->fetch());
    }

    public function buscarPorId(int $id): ?Cuenta
    {
        $stmt = $this->pdo->prepare(
            'SELECT id, numero_cuenta, saldo, cliente_id FROM cuentas WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);

        return $this->hidratar($stmt->fetch());
    }

    public function tieneSaldoSuficiente(int $id, string $valor): bool
    {
        $stmt = $this->pdo->prepare(
            'SELECT saldo >= CAST(:valor AS DECIMAL(12,2)) FROM cuentas WHERE id = :id FOR UPDATE'
        );
        $stmt->execute(['valor' => $valor, 'id' => $id]);
        $resultado = $stmt->fetchColumn();

        if ($resultado === false) {
            throw new CuentaNoEncontradaException();
        }

        return (int) $resultado === 1;
    }

    public function debitar(int $id, string $valor): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cuentas SET saldo = saldo - CAST(:valor AS DECIMAL(12,2)) WHERE id = :id'
        );
        $stmt->execute(['valor' => $valor, 'id' => $id]);
    }

    public function acreditar(int $id, string $valor): void
    {
        $stmt = $this->pdo->prepare(
            'UPDATE cuentas SET saldo = saldo + CAST(:valor AS DECIMAL(12,2)) WHERE id = :id'
        );
        $stmt->execute(['valor' => $valor, 'id' => $id]);
    }

    private function hidratar($fila): ?Cuenta
    {
        if (!$fila) {
            return null;
        }

        return new Cuenta(
            (int) $fila['id'],
            (string) $fila['numero_cuenta'],
            (string) $fila['saldo'],
            (int) $fila['cliente_id']
        );
    }
}
