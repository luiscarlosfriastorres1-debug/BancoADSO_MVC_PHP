<h1 class="hl">Historial de transferencias enviadas</h1>

<section class="tarjeta resumen">
    <p>Total de transferencias enviadas: <strong><?= e((string) $cantidad) ?></strong></p>
    <p>Valor total transferido: <strong><?= e(dinero($total)) ?></strong></p>
</section>

<?php if ($cantidad === 0): ?>
    <p>Aún no has realizado transferencias.</p>
<?php else: ?>
    <table>
        <thead>
            <tr><th>Fecha</th><th>Cuenta destino</th><th>Valor</th></tr>
        </thead>
        <tbody>
            <?php foreach ($tranferencias as $tranferencia): ?>
                <tr>
                    <td><?= e($tranferencia->getFecha()) ?></td>
                    <td><?= e((string) $tranferencia->getNumeroCuentaDestino()) ?></td>
                    <td><?= e(dinero($tranferencia->getValor())) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
