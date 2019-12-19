<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('penitipan/data', '<i class="fa fa-hand-o-left"></i> Kembali Ke Data Penitipan', array('class' => 'btn btn-primary')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <div class="table table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td style="width:25%;">ID Penitipan</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <?= $id ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Tgl.Mulai Penitipan</td>
                                <td>:</td>
                                <td><?= $tanggal ?></td>
                            </tr>
                            <tr>
                                <td>Pelanggan</td>
                                <td>:</td>
                                <td><?= $nik . ' / ' . $namapelanggan ?></td>
                            </tr>
                            <tr>
                                <td>Total Penitipan</td>
                                <td>:</td>
                                <td><?= '<h3>' . $totalpenitipan . ' Gram </h3>' ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <?php
                                    if ($status == 0) {
                                        ?>
                                        <button type="button" class="btn btn-info" onclick="tambahdetail('<?= $id ?>');">
                                            <i class="fa fa-hand-o-down"></i> Tambah Detail
                                        </button>
                                        <script>
                                            function tambahdetail(id) {
                                                $.ajax({
                                                    url: '<?= site_url('penitipan/formtambahdatadetail') ?>',
                                                    data: "&idpenitipan=" + id,
                                                    type: 'post',
                                                    cache: false,
                                                    success: function(data) {
                                                        $('.formtambahdetail').fadeIn();
                                                        $('.formtambahdetail').html(data);
                                                    }
                                                })
                                            }
                                        </script>
                                    <?php
                                    }
                                    ?>
                                    <button type="button" class="btn btn-warning" onclick="window.location.href=('<?= site_url('penitipan/konfirmasipengambilan/' . $id) ?>')">
                                        <i class="fa fa-share"></i> Klik di Sini, Untuk Konfirmasi Pengambilan
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->session->flashdata('pesan') ?>
<div class="formtambahdetail" style="display:none;"></div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <strong class="card-title">
                    Detail Data Penitipan Pelanggan
                </strong>
            </div>
            <div class="card-body">
                <?php
                $querydata = $this->db->query(
                    "SELECT dettitipno AS idpenitipan,dettitipid AS iddetail,dettitiptgl AS tgl, dettitipjml AS jml FROM 
                        detailpenitipan WHERE dettitipno = '$id' ORDER BY dettitiptgl DESC"
                )->result();
                ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah (Gram)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 0;
                        if (count($querydata) > 0) {

                            foreach ($querydata as $data) {
                                $nomor++;
                                ?>
                                <tr>
                                    <td style="width:5%;"><?= $nomor; ?></td>
                                    <td style="width:20%;"><?= $data->tgl; ?></td>
                                    <td align="right" style="width:15%;"><?= number_format($data->jml); ?></td>
                                    <td align="right">
                                        <?php
                                                if ($status == 0) {
                                                    ?>
                                            <button class="btn btn-outline-danger" type="button" onclick="hapusdetailpenitipan('<?= $data->iddetail ?>','<?= $data->idpenitipan ?>');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <script>
                                                function hapusdetailpenitipan(iddetail, penitipanid) {
                                                    Swal.fire({
                                                        title: 'Hapus Detail Penitipan Pelanggan',
                                                        text: "Yakin dihapus ?",
                                                        type: 'question',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ya, Hapus !',
                                                        cancelButtonText: 'Tidak',
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            location.href = ('<?= site_url('penitipan/hapusdetailpenitipan/') ?>' + iddetail + '/' + penitipanid);
                                                        }
                                                    })
                                                }
                                            </script>
                                        <?php
                                                }else{
                                                    echo '<span class="badge badge-success">Sudah di Ambil</span>';
                                                }
                                                ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>