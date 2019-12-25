<table class="table table-bordered">
    <thead>
        <tr class="bg-primary text-white">
            <th>No</th>
            <th>Tgl.Pengeluaran</th>
            <th>Nama Pengeluaran</th>
            <th>Jenis</th>
            <th>Jml (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <?php $nomor = 0;
        $total = 0;
        foreach ($tampildata as $r) :
            $nomor++;
            $total = $total + $r->jmlpengeluaran;
            echo '<tr>';
            echo '<td>' . $nomor . '</td>';
            echo '<td>' . date('d-m-Y', strtotime($r->tglpengeluaran)) . '</td>';
            echo '<td>' . $r->namapengeluaran . '</td>';
            echo '<td>' . $r->jenis . '</td>';
            echo '<td align="right">' . number_format($r->jmlpengeluaran, 0, ",", ".") . '</td>';
            echo '</tr>';
        endforeach;
        ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="4" align="right">Total Pengeluaran</th>
            <td align="right"><?php echo number_format($total, 0, ",", ".") ?></td>
        </tr>
    </tfoot>
</table>