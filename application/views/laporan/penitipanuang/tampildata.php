<style>
th {
    text-align: center;

}
</style>
<table class="table table-striped table-sm">
    <thead>
        <tr class="bg-info text-white">
            <th rowspan="2">No</th>
            <th rowspan="2">No.Penitipan</th>
            <th rowspan="2">Pelanggan</th>
            <th rowspan="2">Tgl.Awal Penitipan</th>
            <th colspan="2">Jumlah (Rp)</th>
            <th rowspan="2">Sisa</th>
            <th rowspan="2">Status</th>
        </tr>
        <tr class="bg-info text-white">
            <th>Penitipan</th>
            <th>Pengambilan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $nomor = 0;
        $totalseluruhpenitipan = 0;
        $totalseluruhpengambilan = 0;
        $totalsisa = 0;
        foreach ($tampildata as $r) :
            $nomor++;
        ?>
        <tr>
            <th><?= $nomor ?></th>
            <td><?= $r->notitip; ?></td>
            <td><?= $r->pelnik . '/' . $r->pelnama; ?></td>
            <td><?= date('d-m-Y', strtotime($r->tglawal)); ?></td>
            <td align="right">
                <!-- Menampilkan Total Penitipan -->
                <?php
                    $sisa;
                    $query = $this->db->get_where('nn_detailtitipuang', ['notitip' => $r->notitip, 'pilihan' => 1])->result();
                    $totalpenitipan = 0;
                    foreach ($query as $x) {
                        $totalpenitipan = $totalpenitipan + $x->nominal;
                    }
                    echo number_format($totalpenitipan, 0, ",", ".");
                    ?>
            </td>
            <td align="right">
                <!-- Menampilkan Total Pengambilan -->
                <?php
                    $query = $this->db->get_where('nn_detailtitipuang', ['notitip' => $r->notitip, 'pilihan' => 2])->result();
                    $totalpengambilan = 0;
                    foreach ($query as $x) {
                        $totalpengambilan = $totalpengambilan + $x->nominal;
                    }
                    echo number_format($totalpengambilan, 0, ",", ".");
                    ?>
            </td>
            <td align="right">
                <?php
                    $sisa = $totalpenitipan - $totalpengambilan;
                    echo number_format($sisa, 0, ",", ".");
                    ?>
            </td>
            <td>
                <?php
                    if ($sisa == 0) {
                        echo '<span class="bagde badge-success">Sudah di Ambil Semua</span>';
                    } else {
                        echo '<span class="bagde badge-danger">Belum di Ambil Semua</span>';
                    }
                    ?>
            </td>
        </tr>
        <?php
            $totalseluruhpenitipan = $totalseluruhpenitipan + $totalpenitipan;
            $totalseluruhpengambilan = $totalseluruhpengambilan + $totalpengambilan;
            $totalsisa = $totalsisa + $sisa;
        endforeach;
        ?>
        <tr>
            <th colspan="4">Total Keseluruhan</th>
            <td align="right" style="font-weight: bold;">
                <?= number_format($totalseluruhpenitipan, 0, ",", "."); ?>
            </td>
            <td align="right" style="font-weight: bold;">
                <?= number_format($totalseluruhpengambilan, 0, ",", "."); ?>
            </td>
            <td align="right" style="font-weight: bold;">
                <?= number_format($totalsisa, 0, ",", "."); ?>
            </td>
            <td></td>
        </tr>
    </tbody>
</table>