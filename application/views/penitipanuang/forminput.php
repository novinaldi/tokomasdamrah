<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href=('<?= site_url('penitipan-uang/data') ?>')">
                        <i class="fa fa-user-check"></i> Cek Data</button>
                </h6>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open_multipart('penitipan-uang/simpandata') ?>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No./ID Penitipan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" required name="nopenitipan" autofocus>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tanggal Awal Penitipan</label>
                    <div class="col-sm-4">
                        <input type="date" class="form-control" required name="tglpenitipan">
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
                                    url: '<?= site_url('penitipan-uang/caripelanggan') ?>',
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
                    <label class="col-sm-3 col-form-label">Jumlah Uang Awal Yang diTitip</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" required name="jmluang">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Keterangan</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="ket" placeholder="Tambahkan Keterangan Jika ada...">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bukti (Foto)</label>
                    <div class="col-sm-9">
                        <input type="file" name="uploadbukti" accept=".jpg, .jpeg, .png">
                        <p>
                            <span class="badge badge-info">Tambahkan Bukti Foto jika ada...</span>
                        </p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <input type="submit" value="Simpan Data" class="btn btn-success">
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
<div class="caripelanggan" style="display:none;"></div>