<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-outline-success" onclick="window.location.href=('<?= site_url('peminjamanemas/data') ?>')">
                        <i class="fa fa-user-check"></i> Lihat Data</button>
                </h6>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open_multipart('peminjamanemas/simpandata') ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No./ID Peminjaman</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" required name="nopeminjaman" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tgl.Awal Peminjaman</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" required name="tglpeminjaman">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pelanggan</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="nikpel" required name="nikpel" placeholder="NIK" readonly>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="namapel" required name="namapel" readonly placeholder="Nama Pelanggan">
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-info" onclick="caripelanggan();">
                            <i class="fa fa-search"></i> Cari
                        </button>
                        <script>
                            function caripelanggan() {
                                $.ajax({
                                    url: '<?= site_url('peminjamanemas/caripelanggan') ?>',
                                    success: function(data) {
                                        $('.caripelanggan').show();
                                        $('.caripelanggan').html(data);
                                        $('#modalcaripelanggan').modal('show');
                                    }
                                });
                            }
                        </script>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jumlah Pinjaman Awal</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" required name="jmlpeminjaman">
                    </div>
                    <div class="col-sm-4">
                        <span class="badge badge-info">* Gunakan tanda (titik), untuk bilangan desimal...</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Upload Bukti (Jika ada)</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" name="uploadbukti" accept=".jpg,.jpeg,.png">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tambahkan Detail/Keterangan (Jika ada)</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="ket">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-block btn-success">
                            <i class="fa fa-save"></i> Simpan Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="caripelanggan" style="display:none;"></div>