<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($titulo ?? 'Banco ADSO') ?> · Banco ADSO</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <header class="barra">
        <span class="marca">Banco ADSO</span>
        <?php if (!empty($autenticado)): ?>
            <nav>
                <a href="index.php?ruta=cuenta">Mi cuenta</a>
                <a href="index.php?ruta=retiro">Retirar</a>
                <a href="index.php?ruta=tranferencia">Transferir</a>
                <a href="index.php?ruta=retiro/historial">Retiros</a>
                <a href="index.php?ruta=tranferencia/historial">Transferencias</a>
                <a href="index.php?ruta=sesion/salir">Salir</a>
            </nav>
        <?php endif; ?>
    </header>

    <main>
        <?php if (!empty($aviso)): ?>
            <p class="aviso aviso-<?= e($aviso['tipo']) ?>"><?= e($aviso['texto']) ?></p>
        <?php endif; ?>

        <?= $contenido ?>
    </main>
</body>
</html>
