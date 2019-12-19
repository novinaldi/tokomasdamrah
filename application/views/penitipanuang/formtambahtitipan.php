<div class="modal fade" id="modalformtambahdata" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Form Tambah Detail Penitipan Pelanggan, ID Penitipan : <?= $notitip; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('penitipan-uang/simpandetailpenitipan') ?>
            <input type="hidden" name="notitip" value="<?= $notitip; ?>">
            <div class="modal-body">
                <p>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Penitipan</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" required name="tgl">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Uang Titipan (Rp)</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control" name="jml" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lampirkan Bukti, Jika ada</label>
                        <div class="col-sm-6">
                            <input type="file" name="uploadbukti" accept=".jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tambahkan Keterangan</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="ket">
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>