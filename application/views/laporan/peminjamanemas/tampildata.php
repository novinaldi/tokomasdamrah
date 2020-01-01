<style>
th {
    text-align: center;

}
</style>
<table class="table table-striped table-sm table-bordered">
    <thead>
        <tr class="bg-info text-white">
            <th rowspan="2">No</th>
            <th rowspan="2">No.Pinjaman</th>
            <th rowspan="2">Pelanggan</th>
            <th rowspan="2">Tgl.Awal Pinjaman</th>
            <th colspan="2">Jumlah (Gram)</th>
            <th rowspan="2">Sisa</th>
            <th rowspan="2">Status</th>
        </tr>
        <tr class="bg-info text-white">
            <th>Pinjaman</th>
            <th>Pembayaran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 0;
        $totalseluruhpeminjaman = 0;
        $totalseluruhpembayaran = 0;
        $totalsisa = 0;
        foreach ($tampildata as $r) :
            $nomor++;
        ?>
        <tr>
            <th><?= $nomor ?></th>
            <td><?= $r->nomor; ?></td>
            <td><?= $r->nikpel . '/' . $r->pelnama; ?></td>
            <td><?= date('d-m-Y', strtotime($r->tglawal)); ?></td>
            <td align="right">
                <!-- Menampilkan Total Penitipan -->
                <?php
                    $sisa;
                    echo number_format($r->jmltotalpinjam, 2, ",", ".");
                    ?>
            </td>
            <td align="right">
                <!-- Menampilkan Total Pengambilan -->
                <?php
                    echo number_format($r->jmltotalbayar, 2, ",", ".");
                    ?>
            </td>
            <td align="right">
                <?php
                    $sisa = $r->jmltotalpinjam - $r->jmltotalbayar;
                    echo number_format($sisa, 2, ",", ".");
                    ?>
            </td>
            <td>
                <?php
                    if ($sisa == 0) {
                        echo '<span class="bagde badge-success">Sudah di Lunasi</span>';
                    } else {
                        echo '<span class="bagde badge-danger">Belum di Lunasi</span>';
                    }
                    ?>
            </td>
        </tr>
        <?php
            $totalseluruhpeminjaman = $totalseluruhpeminjaman + $r->jmltotalpinjam;
            $totalseluruhpembayaran = $totalseluruhpembayaran + $r->jmltotalbayar;
            $totalsisa = $totalsisa + $sisa;
        endforeach;
        ?>
        <tr>
            <th colspan="4">
                Total Keseluruhan
            </th>
            <td style="text-align: right; font-weight: bold;">
                <?= number_format($totalseluruhpeminjaman, 2, ",", "."); ?>
            </td>
            <td style="text-align: right; font-weight: bold;">
                <?= number_format($totalseluruhpembayaran, 2, ",", "."); ?>
            </td>
            <td style="text-align: right; font-weight: bold;">
                <?= number_format($totalsisa, 2, ",", "."); ?>
            </td>
            <td></td>
        </tr>
    </tbody>
</table>