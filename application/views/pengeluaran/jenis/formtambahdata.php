<div class="modal fade" id="modaltambahdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Form Tambah Jenis Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open('pengeluaran/simpandatajenis', ['class' => 'formtambahjenis']) ?>
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <p>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Pengeluaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="namajenis">
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>