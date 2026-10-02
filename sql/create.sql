CREATE DATABASE IF NOT EXISTS db_banco_adso
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_banco_adso;

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE cuentas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_cuenta VARCHAR(50) NOT NULL UNIQUE,
    saldo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    cliente_id INT NOT NULL,

    CONSTRAINT fk_cuentas_clientes
        FOREIGN KEY (cliente_id)
        REFERENCES clientes(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,

    CONSTRAINT fk_usuarios_cuentas
        FOREIGN KEY (cuenta_id)
        REFERENCES cuentas(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE retiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_retiros_cuentas
        FOREIGN KEY (cuenta_id)
        REFERENCES cuentas(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE transferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_origen_id INT NOT NULL,
    cuenta_destino_id INT NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_transferencias_cuenta_origen
        FOREIGN KEY (cuenta_origen_id)
        REFERENCES cuentas(id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_transferencias_cuenta_destino
        FOREIGN KEY (cuenta_destino_id)
        REFERENCES cuentas(id)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
