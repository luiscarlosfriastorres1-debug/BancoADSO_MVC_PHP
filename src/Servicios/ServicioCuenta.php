<?php

namespace App\Servicios;

use App\Excepciones\CuentaDestinoInvalidaException;
use App\Excepciones\CuentaNoEncontradaException;
use App\Excepciones\SaldoInsuficienteException;
use App\Excepciones\ValorInvalidoException;
use App\Nucleo\Conexion;
use App\Repositorios\RepositorioCuentas;
use App\Repositorios\RepositorioRetiros;
use App\Repositorios\RepositorioTranferencias;
use PDO;
use Throwable;

class ServicioCuenta
{
    private PDO $pdo;
    private RepositorioCuentas $cuentas;
    private RepositorioRetiros $retiros;
    private RepositorioTranferencias $tranferencias;
    private ServicioAutenticacion $autenticacion;

    public function __construct()
    {
        $this->pdo           = Conexion::obtener();
        $this->cuentas       = new RepositorioCuentas();
        $this->retiros       = new RepositorioRetiros();
        $this->tranferencias = new RepositorioTranferencias();
        $this->autenticacion = new ServicioAutenticacion();
    }

    public function retirar(int $cuentaId, string $clave, string $valor): void
    {
        $this->autenticacion->confirmarClave($cuentaId, $clave);
        $this->validarValor($valor);

        $this->pdo->beginTransaction();

        try {
            if (!$this->cuentas->tieneSaldoSuficiente($cuentaId, $valor)) {
                throw new SaldoInsuficienteException();
            }

            $this->cuentas->debitar($cuentaId, $valor);
            $this->retiros->registrar($cuentaId, $valor);

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    public function transferir(int $origenId, string $numeroDestino, string $clave, string $valor): void
    {
        $this->autenticacion->confirmarClave($origenId, $clave);

        $destino = $this->cuentas->buscarPorNumero($numeroDestino);
        if ($destino === null) {
            throw new CuentaNoEncontradaException('La cuenta destino no existe.');
        }

        $this->validarValor($valor);

        $this->pdo->beginTransaction();

        try {
            if (!$this->cuentas->tieneSaldoSuficiente($origenId, $valor)) {
                throw new SaldoInsuficienteException();
            }

            if ($destino->getId() === $origenId) {
                throw new CuentaDestinoInvalidaException();
            }

            $this->cuentas->debitar($origenId, $valor);
            $this->cuentas->acreditar($destino->getId(), $valor);
            $this->tranferencias->registrar($origenId, $destino->getId(), $valor);

            $this->pdo->commit();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    private function validarValor(string $valor): void
    {
        if (!preg_match('/^\d{1,10}(\.\d{1,2})?$/', $valor) || $valor <= 0) {
            throw new ValorInvalidoException();
        }
    }
}


?>