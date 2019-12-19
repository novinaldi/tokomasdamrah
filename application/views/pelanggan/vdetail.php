<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pelanggan/index', '<i class="fa fa-hand-o-left"></i> Kembali', array('class' => 'btn btn-warning')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <div class="table table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <td style="width:25%;">NIK KTP Pelanggan</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <?= $nik ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">Nama Pelanggan</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <?= $nama ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">Jenis Kelamin</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <?php if ($jk == 'L') echo 'Laki-Laki';
                                    else echo 'Perempuan'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">No.Handphone / Telp</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <?= $nohp; ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">Alamat</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <?= $alamat ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:25%;">Foto (KTP/Pelanggan)</td>
                                <td style="width:2%;">:</td>
                                <td>
                                    <a href="<?= base_url($foto) ?>" data-toggle="modal" data-target="#lihatfoto">
                                        <img src="<?= base_url($foto) ?>" class="img-responsive" alt="belum ada foto" style="width:20%;">
                                    </a>
                                    <!-- Modal Lihat Gambar -->
                                    <div class="modal fade" id="lihatfoto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Foto dari <?= $nama;?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row justify-content-center">
                                                            <div class="col-md-12">
                                                                <img src="<?= base_url($foto) ?>" class="img-responsive" style="width:100%;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- // -->
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="location.href=('<?= site_url('pelanggan/edit/' . $nik) ?>')">
                                        Edit Data
                                    </button>
                                    <button type="button" class="btn btn-success" onclick="location.href=('<?= site_url('pelanggan/formupload/' . $nik) ?>')">
                                        Upload Foto
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