<h1 class="hl">Realizar transferencia</h1>

<form method="post" action="index.php?ruta=tranferencia/realizar" class="tarjeta">
    <label for="numero_cuenta_destino">Número de cuenta destino</label>
    <input type="text" id="numero_cuenta_destino" name="numero_cuenta_destino" autocomplete="off" required>

    <label for="valor">Valor a transferir</label>
    <input type="text" id="valor" name="valor" inputmode="decimal" autocomplete="off" required>
    <small>Solo dígitos, con punto decimal opcional (ej. 50000 o 50000.50).</small>

    <label for="clave">Confirma tu contraseña</label>
    <input type="password" id="clave" name="clave" autocomplete="current-password" required>

    <button type="submit">Transferir</button>
</form>
