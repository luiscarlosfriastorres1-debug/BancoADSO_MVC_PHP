<?php

namespace App\Nucleo;

use PDO;
use PDOException;
use RuntimeException;

class Conexion
{
    private static ?PDO $instancia = null;

    private function __construct()
    {
    }

    public static function obtener(): PDO
    {
        if (self::$instancia === null) {
            $config = require __DIR__ . '/../../config/basedatos.php';

            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                $config['host'],
                $config['puerto'],
                $config['db'],
                $config['charset'],
            );

            try {
                self::$instancia = new PDO($dsn, $config['user'], $config['password'], [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]);
            } catch (PDOException $e) {
                throw new RuntimeException('No fue posible conectar con la base de datos.', 0, $e);
            }
        }

        return self::$instancia;
    }
}


?>