<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Nucleo\Router;

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax']);
session_start();

$ruta = $_GET['ruta'] ?? 'cuenta/index';

(new Router())->despachar(is_string($ruta) ? $ruta : 'cuenta/index');
