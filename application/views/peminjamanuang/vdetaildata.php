<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <?= anchor('peminjamanuang/data', '<i class="fa fa-backspace"></i> Kembali', array('class' => 'btn btn-outline-warning')) ?>

                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-striped">
                            <tr>
                                <td>No.Peminjaman</td>
                                <td>:</td>
                                <td><?= $nopeminjaman; ?></td>
                            </tr>
                            <tr>
                                <td>Tgl.Awal Peminjaman</td>
                                <td>:</td>
                                <td><?= $tgl; ?></td>
                            </tr>
                            <tr>
                                <td>Pelanggan</td>
                                <td>:</td>
                                <td><?= $nik . '/' . $namapelanggan; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table class="table table-striped">
                            <tr>
                                <td>Total Jumlah Pinjaman (Rp)</td>
                                <td>:</td>
                                <td align="right">
                                    <h4><?= number_format($jmltotalpinjam); ?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td>Total Sudah Bayar (Rp)</td>
                                <td>:</td>
                                <td align="right">
                                    <h4><?= number_format($jmltotalbayar); ?></h4>
                                </td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td align="right">
                                    <?php
                                    $sisa = $jmltotalpinjam - $jmltotalbayar;
                                    if ($sisa == 0) {
                                        echo '<span class="badge badge-success">Sudah Lunas</span>';
                                    } else {
                                        echo '<span class="badge badge-danger">Belum Lunas</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                if ($sisa != 0) {
                    ?>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-info btn-block" onclick="tambahpinjaman('<?= $nopeminjaman ?>')">
                                <i class="fa fw fa-money-check"></i> Tambah Pinjaman
                            </button>
                            <script>
                                function tambahpinjaman(nomor) {
                                    $.ajax({
                                        url: '<?= site_url('peminjamanuang/formtambahpinjaman') ?>',
                                        data: "&nomor=" + nomor,
                                        type: 'post',
                                        cache: false,
                                        success: function(data) {
                                            $('.formtambahdata').show();
                                            $('.formtambahdata').html(data);
                                            $('#modalformtambahdata').modal('show');
                                        }
                                    });
                                }
                            </script>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block" onclick="tambahpembayaran('<?= $nopeminjaman ?>')">
                                <i class="fa fw fa-money-check"></i> Tambah Pembayaran
                            </button>
                            <script>
                                function tambahpembayaran(nomor) {
                                    $.ajax({
                                        url: '<?= site_url('peminjamanuang/formtambahpembayaran') ?>',
                                        data: "&nomor=" + nomor,
                                        type: 'post',
                                        cache: false,
                                        success: function(data) {
                                            $('.formtambahdata').show();
                                            $('.formtambahdata').html(data);
                                            $('#modalformtambahdata').modal('show');
                                        }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                <?php
                }
                ?>
                <p>
                    <?= $this->session->flashdata('validasi') ?>
                </p>
            </div>
        </div>
    </div>
</div>
<div class="formtambahdata" style="display:none;"></div>
<!-- Detail Data -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-warning">
                <h6 class="m-0 font-weight-bold text-white">
                    Data Detail Peminjaman
                </h6>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?php
                $querydatadetail = $this->db->query("SELECT iddetail,nodetail,tgl,IF(pilihan=1,jml,0) AS pinjam,IF(pilihan=2,jml,0) AS bayar,jml,buktifoto,ket FROM detailpinjaman_uang WHERE nodetail='$nopeminjaman' ORDER BY tgl,iddetail ASC");

                $nomor = 0;
                $saldo = 0;
                ?>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pinjaman (Rp)</th>
                            <th>Bayar (Rp)</th>
                            <th>Saldo</th>
                            <th>Ket/Detail</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($querydatadetail->result_array() as $d) {
                            $nomor++;
                            $saldo = $saldo + $d['pinjam'] - $d['bayar'];
                            ?>
                            <tr>
                                <td><?= $nomor; ?></td>
                                <td><?= date('d-m-Y', strtotime($d['tgl'])) ?></td>
                                <td align="right"><?= number_format($d['pinjam'], 0) ?></td>
                                <td align="right"><?= number_format($d['bayar'], 0) ?></td>
                                <td align="right"><?= number_format($saldo, 0) ?></td>
                                <td>
                                    <?php
                                        echo $d['ket'] . '<br>';
                                        if ($d['buktifoto'] != NULL) {
                                            ?>
                                        <p>
                                            <button type="button" class="btn btn-outline-info" onclick="tampilkanbukti('<?= $d['iddetail'] ?>')">
                                                Lihat Bukti
                                            </button>
                                        </p>
                                    <?php
                                        }
                                        ?>
                                </td>
                                <td>
                                    <button type="button" onclick="hapusdetail('<?= $d['iddetail'] ?>','<?= $nopeminjaman ?>');" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data Detail Peminjaman">
                                        <i class="fa fa-trash"></i>
                                    </button>
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
<div class="tampildetailbuktifoto" style="display:none;"></div>
<script>
    function hapusdetail(id, nopeminjaman) {
        Swal.fire({
            title: 'Hapus Detail Peminjaman/Pembayaran',
            text: "Yakin hapus data ini ?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                location.href = ('<?= site_url('peminjamanuang/hapusdetaildata/') ?>' + id + '/' + nopeminjaman);
            }
        })
    }

    function tampilkanbukti(id) {
        $.ajax({
            url: '<?= site_url('peminjamanuang/tampilkanbuktifoto') ?>',
            data: "&id=" + id,
            type: 'post',
            cache: false,
            success: function(data) {
                $('.tampildetailbuktifoto').show();
                $('.tampildetailbuktifoto').html(data);
                $('#modaltampildetailbuktifoto').modal('show');
            }
        });
    }
</script>