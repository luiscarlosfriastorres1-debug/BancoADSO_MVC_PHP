<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Nucleo\Conexion;

$clientes = [

    ['Luisca Frias',   '1120743867', '1500000.00', '1234'],
    ['Luisca Torres',  '1120743866', '2850000.50', '1234'],
    ['Rafael Florez',  '1120743284', '450000.00',  '1234'],
    ['Hele Sar',       '1120743868', '8900000.00', '1234'],
    ['Char Jonhson',   '1120743869', '120000.00',  '1234'],
];

$pdo = Conexion::obtener();

$conteo = $pdo->prepare('SELECT COUNT(*) FROM clientes');
$conteo->execute();
if ((int) $conteo->fetchColumn() > 0) {
    exit("La base de datos ya tiene clientes. Vacíe las tablas antes de sembrar de nuevo.\n");
}

$insertarCliente = $pdo->prepare('INSERT INTO clientes (nombre) VALUES (:nombre)');
$insertarCuenta  = $pdo->prepare('INSERT INTO cuentas (numero_cuenta, saldo, cliente_id) VALUES (:numero, :saldo, :cliente_id)');
$insertarUsuario = $pdo->prepare('INSERT INTO usuarios (cuenta_id, clave_hash) VALUES (:cuenta_id, :clave_hash)');

$pdo->beginTransaction();

try {
    foreach ($clientes as [$nombre, $numero, $saldo, $clave]) {
        $insertarCliente->execute(['nombre' => $nombre]);
        $clienteId = (int) $pdo->lastInsertId();

        $insertarCuenta->execute(['numero' => $numero, 'saldo' => $saldo, 'cliente_id' => $clienteId]);
        $cuentaId = (int) $pdo->lastInsertId();

        $insertarUsuario->execute([
            'cuenta_id'  => $cuentaId,
            'clave_hash' => password_hash($clave, PASSWORD_DEFAULT),
        ]);
    }

    $pdo->commit();
    echo 'Sembrados ' . count($clientes) . " clientes con su cuenta y usuario.\n";
} catch (Throwable $e) {
    $pdo->rollBack();
    throw $e;
}
