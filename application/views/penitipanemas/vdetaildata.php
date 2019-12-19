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
                    <?= anchor('penitipanemas/data', '<i class="fa fa-backspace"></i> Kembali', array('class' => 'btn btn-outline-warning')) ?>

                </h6>
            </div>
            <div class="card-body">
                <p>
                    <?= $this->session->flashdata('validasi'); ?>
                </p>
                <div class="row">
                    <div class="col">
                        <table class="table table-striped table-sm">
                            <tr>
                                <td>No.Penitipan</td>
                                <td>:</td>
                                <td><?= $nopenitipan ?></td>
                            </tr>
                            <tr>
                                <td>Tgl.Awal Penitipan</td>
                                <td>:</td>
                                <td><?= $tglawal ?></td>
                            </tr>
                            <tr>
                                <td>Pelanggan</td>
                                <td>:</td>
                                <td><?= $pelanggan ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <div class="row">
                            <table class="table table-striped table-sm">
                                <tr>
                                    <td>Total Penitipan</td>
                                    <td>:</td>
                                    <td align="right"><?= '<span class="badge badge-info" style="font-size:16pt;">' . $totaltitipan . '</span>' ?></td>
                                </tr>
                                <tr>
                                    <td>Total Ambil</td>
                                    <td>:</td>
                                    <td align="right"><?= '<span class="badge badge-info" style="font-size:16pt;">' . $totalambil . '</span>' ?></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>
                                        <?php
                                        $sisa = $totaltitipan - $totalambil;
                                        if ($sisa == 0) {
                                            echo '<span class="badge badge-success" style="font-size:16pt;">Sudah di Ambil Semua</span>';
                                        } else {
                                            echo '<span class="badge badge-danger" style="font-size:10pt;">Belum di Ambil Semua</span>';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-bordered">
                            <tr>
                                <td colspan="3" class="text-center bg-secondary text-white">Total Berdasarkan Jenis</td>
                            </tr>
                            <tr>
                                <td class="text-center">Mas Antam</td>
                                <td class="text-center">Mas Murni</td>
                                <td class="text-center">Perhiasan</td>
                            </tr>
                            <tr>
                                <td class="text-right"><?= number_format($total_masantam, 2, ",", ".") ?></td>
                                <td class="text-right"><?= number_format($total_masmurni, 2, ",", ".") ?></td>
                                <td class="text-right"><?= number_format($total_perhiasan, 2, ",", ".") ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
                if ($sisa !== 0) {
                    ?>

                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-block btn-info" onclick="tambahpenitipanemas('<?= $nopenitipan; ?>')">
                                Tambah Penitipan
                            </button>
                            <script>
                                function tambahpenitipanemas(no) {
                                    $.ajax({
                                        url: '<?= site_url('penitipanemas/tambahpenitipan') ?>',
                                        data: "&no=" + no,
                                        type: 'post',
                                        cache: false,
                                        success: function(data) {
                                            $('.formtambahpenitipan').show();
                                            $('.formtambahpenitipan').html(data);
                                            $('#modalformtambahpenitipan').modal('show');
                                        }
                                    });
                                }
                            </script>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-block btn-primary" onclick="tambahpengambilanemas('<?= $nopenitipan; ?>')">
                                Tambah Pengambilan
                            </button>
                            <script>
                                function tambahpengambilanemas(no) {
                                    $.ajax({
                                        url: '<?= site_url('penitipanemas/tambahpengambilan') ?>',
                                        data: "&no=" + no,
                                        type: 'post',
                                        cache: false,
                                        success: function(data) {
                                            $('.formtambahpengambilan').show();
                                            $('.formtambahpengambilan').html(data);
                                            $('#modalformtambahpengambilan').modal('show');
                                        }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                <?php
                }
                ?>
                <div class="row">
                    <div class="col">
                        <p>
                            <?= $this->session->flashdata('pesan') ?>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="formtambahpenitipan" style="display:none;"></div>
<div class="formtambahpengambilan" style="display:none;"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-success">
                <h6 class="m-0 font-weight-bold text-white">
                    Data Detail
                </h6>
            </div>
            <div class="card-body">
                <?php
                $q = "SELECT id,notitip,tgl,idjenis,jenisnama,
                    CASE pilihan WHEN 1 THEN jml ELSE 0 END AS titip,
                    CASE pilihan WHEN 2 THEN jml ELSE 0 END AS ambil,
                    jml,buktifoto,ket FROM detail_penitipanemas JOIN jenisemas ON jenisid=idjenis WHERE notitip = ?";
                $querydetail = $this->db->query($q, [$nopenitipan])
                ?>
                <div class="row">
                    <div class="col">
                        <table class="table table-striped table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Titipan<br>(Gram)</th>
                                    <th>Pengambilan<br>(Gram)</th>
                                    <th>Saldo<br>(Gram)</th>
                                    <th>Jenis Emas</th>
                                    <th>Keterangan</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $nomor = 0;
                                $saldo = 0;
                                foreach ($querydetail->result_array() as $r) {
                                    $nomor++;
                                    $saldo = ($saldo + $r['titip']) - $r['ambil'];
                                    ?>
                                    <tr>
                                        <td><?= $nomor; ?></td>
                                        <td><?= date('d-m-Y', strtotime($r['tgl'])) ?></td>
                                        <td><?= number_format($r['titip'], 2, ",", ".") ?></td>
                                        <td><?= number_format($r['ambil'], 2, ",", ".") ?></td>
                                        <td><?= number_format($saldo, 2, ",", ".") ?></td>
                                        <td><?= $r['jenisnama'] ?></td>
                                        <td><?php
                                                echo $r['ket'];
                                                if ($r['buktifoto'] != NULL) {
                                                    ?>
                                                <p>
                                                    <button type="button" class="btn btn-outline-info" onclick="lihatbuktipenitipan('<?= $r['id'] ?>')">Lihat Bukti</button>
                                                </p>
                                            <?php
                                                }
                                                ?>
                                        </td>
                                        <td>
                                            <button type="button" onclick="hapusdetail('<?= $r['id'] ?>','<?= $nopenitipan ?>');" class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data Detail Penitipan">
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
    </div>
</div>
<div class="tampildetailbuktifoto" style="display:none;"></div>
<script>
    function hapusdetail(id, nopenitipan) {
        Swal.fire({
            title: 'Hapus Detail Penitipan Emas',
            text: "Yakin hapus data ini ?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                location.href = ('<?= site_url('penitipanemas/hapusdetaildata/') ?>' + id + '/' + nopenitipan);
            }
        })
    }

    function lihatbuktipenitipan(id) {
        $.ajax({
            url: '<?= site_url('penitipanemas/tampilkanbuktifoto') ?>',
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