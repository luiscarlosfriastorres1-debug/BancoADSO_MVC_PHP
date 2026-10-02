<h1 class="hl">Historial de retiros</h1>

<section class="tarjeta resumen">
    <p>Total de retiros: <strong><?= e((string) $cantidad) ?></strong></p>
    <p>Valor total retirado: <strong><?= e(dinero($total)) ?></strong></p>
</section>

<?php if ($cantidad === 0): ?>
    <p>Aún no has realizado retiros.</p>
<?php else: ?>
    <table>
        <thead>
            <tr><th>Fecha</th><th>Valor</th></tr>
        </thead>
        <tbody>
            <?php foreach ($retiros as $retiro): ?>
                <tr>
                    <td><?= e($retiro->getFecha()) ?></td>
                    <td><?= e(dinero($retiro->getValor())) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
