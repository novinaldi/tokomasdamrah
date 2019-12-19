<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Tgl.Transaksi</th>
            <th>Masuk</th>
            <th>Keluar</th>
            <th>Sisa Saldo</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 0;
        $masuk = 0;
        foreach ($tampil as $r) {
            $nomor++;
            $masuk = $masuk + $r->masuk - $r->keluar;
            ?>
            <tr>
                <td><?= $nomor; ?></td>
                <td><?= $r->tgl ?></td>
                <td><?= number_format($r->masuk, 0) ?></td>
                <td><?= number_format($r->keluar, 0) ?></td>
                <td>
                    <?= number_format($masuk, 0); ?>
                </td>
            </tr>
        <?php
        }
        ?>

    </tbody>
</table>