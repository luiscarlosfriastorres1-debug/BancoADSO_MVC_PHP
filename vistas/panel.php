<h1 class="hl">Mi cuenta</h1>

<section class="tarjeta">
    <p>Titular: <strong><?= e($titular) ?></strong></p>
    <p>Número de cuenta: <strong><?= e($numeroCuenta) ?></strong></p>
    <p class="etiqueta">Saldo disponible</p>
    <p class="saldo"><?= e(dinero($saldo)) ?></p>
</section>
