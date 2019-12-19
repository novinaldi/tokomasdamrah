<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <button type="button" class="btn btn-danger tutupform">
                        <i class="fa fa-remove"></i> Tutup Form
                    </button>
                    <script>
                        $(document).on('click', '.tutupform', function(e) {
                            $('.formpembayaran').fadeOut();
                        });
                    </script>
                </strong>
            </div>
            <div class="card-body">
                <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                    <span class="badge badge-pill badge-primary">Info !!!</span>
                    <strong>Tambahkan Pembayaran Pelanggan melalui form berikut :</strong>
                </div>
                <p>
                    <?= form_open_multipart('pinjaman/simpanpembayaran', array('class' => 'form-horizontal')) ?>
                    <input type="hidden" name="nopinjaman" value="<?= $nopinjaman ?>">
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Tgl.Bayar</label></div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="date" class="form-control" name="tglbayar" id="tglbayar" required>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Jumlah (Gram)</label></div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="number" class="form-control" name="jmlbayar" id="jmlbayar" required>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Cara Pembayaran</label></div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <select class="form-control" name="carabayar">
                                    <option value="1">Cash/Tunai</option>
                                    <option value="2">Transfer</option>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Jika Transfer, Silahkan Bukti Transfer</label></div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="file" name="uploadbukti" accept=".jpg,.jpeg,.png">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">

                        </div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="submit" value="Simpan Data" class="btn btn-outline-success">
                            </p>
                        </div>
                    </div>
                    <?= form_close() ?>
                </p>
            </div>
        </div>
    </div>
</div>