USE db_banco_adso;

INSERT INTO clientes (nombre) VALUES
('Luisca Frias'),
('Luisca Torres'),
('Rafael Florez'),
('Hele Sar'),
('Char Jonhson');

INSERT INTO cuentas (numero_cuenta, saldo, cliente_id) VALUES
('1120743867', 1500000.00, 1),
('1120743866', 2850000.50, 2),
('1120743284', 450000.00, 3),
('1120743868', 8900000.00, 4),
('1120743869', 120000.00, 5);

INSERT INTO usuarios (cuenta_id, clave_hash) VALUES
(1, '$2y$12$fGVuQQPPhKznTCdwCtNC3OrI6EF6vclSsA.gsyYy49UPLFQafXCI2'),
(2, '$2y$12$6dQ0JWjx/ckgZokoZ5TKHOYbhHKo.NnAxIcF6lok/OErdVfTU14Ie'),
(3, '$2y$12$LrorXVnN7On.vXDYFpu4v.0juLd20uZtHVWC3lvhTT2A8Z18BYA9W'),
(4, '$2y$12$oCrUz02CIYN.mff.fwor0eVg56A7ti3hHgm5/5IWjbhaKnrAm/Ifm'),
(5, '$2y$12$TF5eBiEZdZSLA0YMOUkGDurLJ/xr8aEgzgPvp6kZN5ttVocTN.rIO');

INSERT INTO retiros (cuenta_id, valor) VALUES
(1, 50000.00),
(3, 100000.00),
(4, 500000.00),
(2, 200000.00),
(5, 20000.00);

INSERT INTO transferencias (cuenta_origen_id, cuenta_destino_id, valor) VALUES
(2, 1, 150000.00),
(4, 3, 300000.00),
(1, 5, 45000.00),
(3, 2, 80000.00),
(4, 1, 120000.00);
