<div class="modal fade" id="modalformtambahpengambilan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Form Tambah Detail Pengambilan , No.Penitipan : <?= $nopenitipan; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('penitipanemas/simpandetailpengambilan') ?>
            <input type="hidden" name="nopenitipan" value="<?= $nopenitipan; ?>">
            <div class="modal-body">
                <p>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Pengambilan</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" required name="tgl">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah Emas diAmbil (Gram)</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="jml" required>
                        </div>
                        <div class="col-sm-4">
                            <span class="badge badge-info">Gunakan tanda titik untuk bilangan berkoma...</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Emas</label>
                        <div class="col-sm-4">
                            <select name="jenis" class="form-control" required>
                                <option value="" selected>-Pilih-</option>
                                <?php
                                foreach ($datajenisemas->result_array() as $jenis) {
                                    ?>
                                    <option value="<?= $jenis['jenisid']; ?>"><?= $jenis['jenisnama']; ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Lampirkan Bukti, Jika ada</label>
                        <div class="col-sm-6">
                            <input type="file" name="uploadbukti" accept=".jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tambahkan Keterangan Penitipan</label>
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