<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('penitipan/detail/' . $idpenitipan, '<i class="fa fa-reply"></i> Kembali', array('class' => 'btn btn-warning')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <div class="table table-responsive">
                        <?= $this->session->flashdata('pesan') ?>
                        <table class="table table-striped">
                            <tr>
                                <td style="width:20%;">ID Penitipan</td>
                                <td style="width:2%;">:</td>
                                <td><?= $idpenitipan ?></td>
                            </tr>
                            <tr>
                                <td>Tgl.Mulai Penitipan</td>
                                <td>:</td>
                                <td><?= $tglpenitipan; ?></td>
                            </tr>
                            <tr>
                                <td>Pelanggan</td>
                                <td>:</td>
                                <td><?= $pelanggan; ?></td>
                            </tr>
                            <tr>
                                <td>Total Penitipan</td>
                                <td>:</td>
                                <td><?= $totalpenitipan; ?></td>
                            </tr>
                            <tr>
                                <td>Status Pengambilan</td>
                                <td>:</td>
                                <td>
                                    <?php
                                    if ($status == '1') {
                                        ?>
                                        <span class="badge badge-success">Sudah di Ambil</span>
                                    <?php
                                    } else {
                                        ?>
                                        <span class="badge badge-danger">Belum di Ambil</span>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            if ($status == 1) {
                                echo '<tr>
                                        <td>Tgl. Pengambilan</td>
                                        <td>:</td>
                                        <td>' . $tglpengambilan . '</td>
                                    </tr>';
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="button" class="btn btn-info" onclick="batalkankonfirmasipengambilan('<?= $idpenitipan ?>')">
                                            <i class="fa fa-ban"></i> Batalkan Pengambilan
                                        </button>

                                    </td>
                                    <script>
                                        function batalkankonfirmasipengambilan(idpenitipan) {
                                            Swal.fire({
                                                title: 'Batalkan Konfirmasi Pengambilan',
                                                text: "Yakin untuk data penitipan ini ?",
                                                type: 'question',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Ya, Hapus !',
                                                cancelButtonText: 'Tidak',
                                            }).then((result) => {
                                                if (result.value) {
                                                    location.href = ('<?= site_url('penitipan/batalkankonfirmasipengambilan/') ?>' + idpenitipan);
                                                }
                                            });
                                        }
                                    </script>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>

                        <?php
                        if ($status == 0) {
                            ?>
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <div class="card-title">
                                        Inputkan Tanggal Pengambilan
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        <?= form_open('penitipan/simpanpengambilan', ['class' => 'form-horizontal']) ?>
                                        <input type="hidden" name="idpenitipan" value=<?= $idpenitipan ?>>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                                <label for="text-input" class="form-control-label">Tanggal</label>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="date" name="tglambil" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-3">
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <input type="submit" class="btn btn-success" value="Simpan">
                                            </div>
                                        </div>
                                        <?= form_close() ?>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>