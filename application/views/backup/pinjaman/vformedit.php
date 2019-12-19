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
                    Fasilitas Edit ini hanya digunakan untuk mengedit <strong>Jumlah Pinjaman Pelanggan</strong>
                </div>

                <p>
                    <?= $this->session->flashdata('pesan') ?>
                    <?= form_open('pinjaman/updatedata', array('class' => 'form-horizontal')) ?>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Tgl.Peminjaman</label></div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="date" class="form-control" name="tglpinjam" id="tglpinjam" value="<?= $tglpinjaman ?>" readonly>
                            </p>
                        </div>

                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">No.Pinjaman</label></div>
                        <div class="col-12 col-md-6">
                            <p class="form-control-static">
                                <input type="text" class="form-control nopinjaman" name="nopinjaman" value="<?= $nopinjaman ?>" placeholder="Nomor ini otomatis" value="" readonly>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Cari Pelanggan</label></label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <input value="<?= $nikpelanggan ?>" type="text" readonly class="form-control" id="nikpelanggan" name="nikpelanggan" placeholder="NIK Pelanggan">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label"></label></label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <input value="<?= $namapelanggan ?>" type="text" class="form-control" id="namapelanggan" name="namapelanggan" placeholder="Nama Pelanggan" readonly>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Jumlah Pinjaman (Gram)</label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <input type="number" required class="form-control" name="jmlpinjam" value="<?= $jmlpinjaman ?>">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label"></label></label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Update
                                </button>
                            </p>
                        </div>
                    </div>

                    <?= form_close(); ?>
                </p>
            </div>
        </div>
    </div>
</div>