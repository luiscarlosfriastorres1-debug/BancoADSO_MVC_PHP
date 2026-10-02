# Banco ADSO

Aplicación bancaria simulada, hecha en PHP con programación orientada a objetos, patrón MVC artesanal (sin frameworks), PDO y MySQL. Es el taller práctico del programa de Análisis y Desarrollo de Software (ADSO) del SENA.

Un cliente entra con su número de cuenta y contraseña, consulta su saldo en vivo, hace retiros y transferencias, y revisa sus historiales.

## Funcionalidades

- Login con número de cuenta y contraseña (sin registro público).
- Panel con titular, número de cuenta y saldo siempre actualizado desde la base de datos.
- Retiro con reconfirmación de contraseña.
- Transferencia a otra cuenta, con reconfirmación de contraseña y transacción atómica.
- Historial de retiros** con cantidad y valor total.
- Historial de transferencias enviadas** con cantidad y valor total.
- Cerrar sesión.

## Tecnologías

 Tecnología  Uso 

| PHP 8.1 o superior | Lenguaje, con POO |
| Composer | Autoload PSR-4 (`App\` apunta a `src/`) |
| MySQL / MariaDB | Base de datos `db_banco_adso` |
| PDO | Acceso a datos con consultas preparadas |
| HTML5 y CSS3 | Vistas, sin JavaScript |

## Requisitos previos

- PHP 8.1 o superior con la extensión `pdo_mysql` activa
- MySQL o MariaDB (por ejemplo, el que trae XAMPP)
- Composer

## Instalación

1. Clona o copia el proyecto** y entra a la carpeta:

   ```bash
   cd BancoADSO
   ```

2. Regenera el autoload** de Composer (registra las clases y `src/ayudantes.php`):

   ```bash
   composer dump-autoload
   ```

3. Crea la base de datos y las tablas.** Ejecuta `sql/create.sql` desde phpMyAdmin (pestaña *Importar*) o por consola:

   ```bash
   mysql -u root -p < sql/create.sql
   ```

4. Carga los datos de ejemplo.** Usa **una** de estas dos opciones, no ambas:

   - `sql/insert.sql`: clientes, cuentas, usuarios, y algunos retiros y transferencias de muestra.
   - `php sql/siembra.php`: solo clientes, cuentas y usuarios (las claves se guardan con `password_hash()`).

5. Revisa la configuración** de conexión en `config/basedatos.php`:

   ```php
   return [
       "host"     => "127.0.0.1",
       "puerto"   => "3306",
       "db"       => "db_banco_adso",
       "user"     => "root",
       "password" => "",
       "charset"  => "utf8mb4",
   ];
   ```

6. Inicia el servidor** desde la raíz del proyecto:

   ```bash
   php -S localhost:8000 -t public
   ```

   Abre <http://localhost:8000> en el navegador.

   
## Cuentas de prueba

La contraseña de todas es **`1234`**.

| Titular | Número de cuenta |
|---|---|
| Luisca Frias | 1120743867 |
| Luisca Torres | 1120743866 |
| Rafael Florez | 1120743284 |
| Hele Sar | 1120743868 |
| Char Jonhson | 1120743869 |

## Rutas

El proyecto tiene un único punto de entrada, `public/index.php`, y las rutas se envían así: `index.php?ruta=controlador/accion`.

| Ruta | Método | Qué hace |
|---|---|---|
| `sesion/login` | GET | Muestra el formulario de ingreso |
| `sesion/ingresar` | POST | Valida las credenciales e inicia la sesión |
| `sesion/salir` | GET | Cierra la sesión |
| `cuenta` | GET | Panel con el saldo |
| `retiro` | GET | Formulario de retiro |
| `retiro/realizar` | POST | Ejecuta el retiro |
| `retiro/historial` | GET | Historial de retiros |
| `tranferencia` | GET | Formulario de transferencia |
| `tranferencia/realizar` | POST | Ejecuta la transferencia |
| `tranferencia/historial` | GET | Historial de transferencias enviadas |

Todas las rutas, excepto las de `sesion`, exigen haber iniciado sesión.

## Estructura del proyecto

```
BancoADSO/
├── config/
│   └── basedatos.php          Datos de conexión a MySQL
├── public/                    Única carpeta accesible desde el navegador
│   ├── index.php              Punto de entrada
│   └── style/style.css
├── sql/
│   ├── create.sql             Base de datos y tablas
│   ├── insert.sql             Datos de ejemplo
│   └── siembra.php            Alternativa a insert.sql
├── src/                       Código PHP (namespace App\)
│   ├── Nucleo/                Router, ControladorBase, Vista, Conexion
│   ├── Controladores/         Reciben las peticiones y eligen la vista
│   ├── Servicios/             Reglas del negocio y transacciones
│   ├── Repositorios/          Consultas SQL (PDO)
│   ├── Modelos/               Cliente, Cuenta, Usuario, Retiro, Tranferencia
│   ├── Excepciones/           Errores de dominio
├── vistas/                    Pantallas HTML
│   └── errores/               404 y 500
└── composer.json
```

## Cómo funciona

Cada petición recorre las mismas capas:

```
Navegador → index.php → Router → Controlador → Servicio → Repositorio → MySQL
```

- **Router:** convierte `retiro/realizar` en `RetiroControlador::realizarAccion()`.
- **Controlador:** lee el formulario, llama al servicio, atrapa las excepciones y elige la vista. No tiene SQL.
- **Servicio:** aplica las reglas del banco y maneja las transacciones.
- **Repositorio:** es el único lugar con SQL; todas las consultas son preparadas.
- **Vista:** solo muestra datos.

## Reglas del negocio

**Retiro**, en este orden:

1. Se confirma la contraseña.
2. El valor debe ser numérico y mayor a 0.
3. El saldo debe alcanzar.

**Transferencia**, en este orden:

1. Se confirma la contraseña.
2. La cuenta destino debe existir.
3. El valor debe ser numérico y mayor a 0.
4. El saldo debe alcanzar.
5. El destino debe ser distinto de la cuenta de origen.

El valor acepta solo dígitos con punto decimal opcional y hasta 2 decimales (por ejemplo `50000` o `50000.50`). No se aceptan comas ni separadores de miles.

En la transferencia, el débito, el abono y el registro se ejecutan dentro de una transacción: si algo falla, `rollBack()` deja los saldos como estaban.

## Base de datos

El modelo está en tercera forma normal, con cinco tablas:

| Tabla | Campos principales |
|---|---|
| `clientes` | `id`, `nombre` |
| `cuentas` | `id`, `numero_cuenta` (único), `saldo` DECIMAL(12,2), `cliente_id` |
| `usuarios` | `id`, `cuenta_id` (único), `clave_hash` |
| `retiros` | `id`, `cuenta_id`, `valor`, `fecha` |
| `transferencias` | `id`, `cuenta_origen_id`, `cuenta_destino_id`, `valor`, `fecha` |

Las llaves foráneas usan `ON DELETE RESTRICT` y el dinero siempre es `DECIMAL`, nunca `FLOAT`.

## Seguridad

- Contraseñas guardadas con `password_hash()` y verificadas con `password_verify()`.
- La cuenta activa se toma siempre de la sesión, nunca de un formulario o de la URL.
- Mensaje idéntico cuando falla el número de cuenta o la contraseña.
- Consultas preparadas en todos los repositorios (sin concatenar datos en el SQL).
- Toda salida en las vistas pasa por `e()` para evitar XSS.
- Se regenera el id de sesión al iniciar sesión.
- Los errores inesperados se registran en el log del servidor y el usuario ve una pantalla 500 sin detalles técnicos.

## Autor

Luisca Frias, aprendiz del programa Análisis y Desarrollo de Software (ADSO), SENA.
