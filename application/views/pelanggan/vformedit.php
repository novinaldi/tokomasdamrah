<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pelanggan/detail/' . $nik, '<i class="fa hand-point-left"></i> Kembali', array('class' => 'btn btn-warning')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= form_open('pelanggan/updatedata', array('class' => 'form-horizontal')) ?>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">NIK (Nomor Induk KTP)</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input value="<?= $nik ?>" readonly type="text" name="nik" class="form-control">


                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Nama Pelanggan</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input type="text" name="nama" class="form-control" value="<?= $nama ?>">
                                <?php
                                if (form_error('nama') != NULL) {
                                    echo '<div class="alert alert-danger">' . form_error('nama') . '</div>';
                                }
                                ?>
                            </p>

                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Jenis Kelamin</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input type="radio" name="jk" value="L" <?php if ($jk == 'L') echo 'checked' ?>> Laki-Laki
                                <input type="radio" name="jk" value="P" <?php if ($jk == 'P') echo 'checked' ?>> Perempuan
                                <?php
                                if (form_error('jk') != NULL) {
                                    echo '<div class="alert alert-danger">' . form_error('jk') . '</div>';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">No.Hp/Telp</label>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="text" name="nohp" class="form-control" value="<?= $nohp ?>">
                                <?php
                                if (form_error('nohp') != NULL) {
                                    echo '<div class="alert alert-danger">' . form_error('nohp') . '</div>';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Alamat</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <textarea class="form-control" name="alamat" placeholder="Inputkan Alamat Lengkap"><?= $alamat; ?></textarea>
                                <?php
                                if (form_error('alamat') != NULL) {
                                    echo '<div class="alert alert-danger">' . form_error('alamat') . '</div>';
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label"></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <?= form_submit('simpan', 'Update Data', array('class' => 'btn btn-success')) ?>
                            </p>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </p>
            </div>
        </div>
    </div>
</div>