<h1 class="hl">Ingresar</h1>

<form method="post" action="index.php?ruta=sesion/ingresar" class="tarjeta">
    <?php if (!empty($error)): ?>
        <p class="aviso aviso-error"><?= e($error) ?></p>
    <?php endif; ?>

    <label for="numero_cuenta">Número de cuenta</label>
    <input type="text" id="numero_cuenta" name="numero_cuenta" value="<?= e($numeroCuenta ?? '') ?>" autocomplete="username" required>

    <label for="clave">Contraseña</label>
    <input type="password" id="clave" name="clave" autocomplete="current-password" required>

    <button type="submit">Ingresar</button>
</form>
