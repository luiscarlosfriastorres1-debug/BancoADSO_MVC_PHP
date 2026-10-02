<h1 class="hl">Realizar retiro</h1>

<form method="post" action="index.php?ruta=retiro/realizar" class="tarjeta">
    <label for="valor">Valor a retirar</label>
    <input type="text" id="valor" name="valor" inputmode="decimal" autocomplete="off" required>
    <small>Solo dígitos, con punto decimal opcional (ej. 50000 o 50000.50).</small>

    <label for="clave">Confirma tu contraseña</label>
    <input type="password" id="clave" name="clave" autocomplete="current-password" required>

    <button type="submit">Retirar</button>
</form>
