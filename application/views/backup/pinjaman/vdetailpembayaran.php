<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pinjaman/data/', '<i class="fa fa-check-square"></i> Lihat Data', array('class' => 'btn btn-primary')) ?>
                </strong>
            </div>
            <div class="card-body">
                <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                    <span class="badge badge-pill badge-primary">Info !!!</span>
                    <strong>Silahkan Tambahkan Pembayaran Dari Pinjaman Yang di-lakukan Pelanggan</strong>
                </div>

                <p>
                    <div class="table table-responsive">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td style="width:20%;">No.Pinjaman</td>
                                        <td style="width:2%;">:</td>
                                        <td>
                                            <?= $nopinjaman; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Tgl.Peminjaman</td>
                                        <td>:</td>
                                        <td><?= $tglpinjaman; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Pelanggan</td>
                                        <td>:</td>
                                        <td><?= $nikpelanggan . ' / ' . $namapelanggan; ?></td>
                                    </tr>
                                </table>

                            </div>
                            <div class="col-md-6">
                                <table class="table table-striped">
                                    <tr>
                                        <td>Total Peminjaman (Gram)</td>
                                        <td>:</td>
                                        <td><?= $jmlpinjaman; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td><?php
                                            if ($status == 1) {
                                                echo '<span class="badge badge-success">Sudah Lunas</span>';
                                            } else {
                                                echo '<span class="badge badge-danger">Belum Lunas</span>';
                                            }
                                            ?></td>
                                    </tr>
                                    <tr>
                                        <td>Sisa (Gram)</td>
                                        <td>:</td>
                                        <td>
                                            <?= $sisa; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <?php
                                            if ($status == 0) {
                                                ?>
                                                <button type="button" class="btn btn-success" onclick="lakukanpembayaran('<?= $nopinjaman ?>')">
                                                    <i class="fa fa-hand-o-down"></i> Lakukan Pembayaran
                                                </button>
                                                <script>
                                                    function lakukanpembayaran(nopinjaman) {
                                                        $.ajax({
                                                            url: '<?= site_url('pinjaman/formtambahpembayaran') ?>',
                                                            data: "&nopinjaman=" + nopinjaman,
                                                            type: 'post',
                                                            cache: false,
                                                            success: function(data) {
                                                                $('.formpembayaran').fadeIn();
                                                                $('.formpembayaran').html(data);
                                                            }
                                                        })
                                                    }
                                                </script>
                                            <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->session->flashdata('pesan'); ?>
<div class="formpembayaran" style="display:none;"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <strong class="card-title">
                    Data Pembayaran Dari Pinjaman Pelanggan
                </strong>
            </div>
            <div class="card-body">
                <?php
                $query = $this->db->get_where('bayarpinjaman', ['bayarpinjamanno' => $nopinjaman]);
                $totaldata = $query->num_rows();
                ?>
                <p>
                    <h5>Total Data : <?= $totaldata ?></h5>
                </p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl.Bayar</th>
                            <th>Jml.Bayar (Gram)</th>
                            <th>Cash/Transfer</th>
                            <th>
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 0;
                        foreach ($query->result_array() as $d) {
                            $nomor++;
                            ?>
                            <tr>
                                <td><?= $nomor ?></td>
                                <td><?= date('d-m-Y', strtotime($d['bayartgl'])) ?></td>
                                <td align=right><?= number_format($d['bayarjml'], 0) ?></td>
                                <td>
                                    <?php
                                        if ($d['bayarcara'] == 1) {
                                            echo '<span class="badge badge-primary">Bayar Cash</span>';
                                        } else {
                                            echo '<span class="badge badge-success">Transfer</span>';
                                        }
                                        ?>
                                    <?php
                                        if ($d['bayarcara'] == 2) {
                                            ?>
                                        <a class="btn btn-outline-info" target="_blank" href="<?= base_url($d['bayarfoto']) ?>">Lihat Bukti Transfer</a>
                                    <?php
                                        }
                                        ?>
                                </td>
                                <td>
                                    <?php
                                        if ($status == 0) {
                                            ?>
                                        <button type="button" class="btn btn-outline-danger" onclick="hapusbayarpinjaman('<?= $d['bayarid'] ?>','<?= $nopinjaman ?>')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <script>
                                            function hapusbayarpinjaman(idbayar, nopinjaman) {
                                                Swal.fire({
                                                    title: 'Hapus Pembayaran ini',
                                                    text: "Yakin dihapus ?",
                                                    type: 'question',
                                                    showCancelButton: true,
                                                    confirmButtonColor: '#3085d6',
                                                    cancelButtonColor: '#d33',
                                                    confirmButtonText: 'Ya, Hapus !',
                                                    cancelButtonText: 'Tidak',
                                                }).then((result) => {
                                                    if (result.value) {
                                                        location.href = ('<?= site_url('pinjaman/hapusbayar/') ?>' + idbayar + '/' + nopinjaman);
                                                    }
                                                })
                                            }
                                        </script>
                                    <?php
                                        } else {
                                            echo '<span class="badge badge-success">Pinjaman ini sudah dilunasi</span>';
                                        }
                                        ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>