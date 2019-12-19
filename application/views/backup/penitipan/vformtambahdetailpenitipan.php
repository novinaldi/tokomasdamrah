<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<script>
    $(document).on('click', '.tutupform', function(e) {
        $('.formtambahdetail').fadeOut();
    });
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <button type="button" class="btn btn-danger tutupform">
                        <i class="fa fa-remove"></i> Tutup Form
                    </button>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= form_open('penitipan/simpandetailpenitipan', ['class' => 'formtambahdetailpenitipan form-horizontal']) ?>
                    <input type="hidden" name="idpenitipan" value="<?= $idpenitipan ?>">
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class="form-control-label">Tanggal Penitipan</label>
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="date" name="tgldetailpenitipan" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class="form-control-label">Tanggal Penitipan</label>
                        </div>
                        <div class="col-12 col-md-4">
                            <input type="number" name="jml" class="form-control" placeholder="Satuan (Gram)" required>
                            <span class="badge badge-info">Inputkan Jumlah Yang di-Titipan (Satuan Gram)</span>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-success">
                                Simpan Penitipan
                            </button>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </p>
            </div>
        </div>
    </div>
</div>