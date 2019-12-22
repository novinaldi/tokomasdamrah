<div class="modal fade" id="modaleditdatapengeluaran" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Form Edit Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('pengeluaran/updatedatapengeluaran', ['class' => 'formtambahdata']) ?>
            <input type="hidden" name="id" value="<?= $id ?>">
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <p>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tgl. Pengeluaran</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tgl" value="<?= $tgl ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Pengeluaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" value="<?= $nama ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Pengeluaran</label>
                        <div class="col-sm-5">
                            <select name="jenis" id="jenis" class="form-control" required>
                                <option selected value="">=Pilih=</option>
                                <?php
                                foreach ($datajenis->result_array() as $j) {
                                    if ($idjenis == $j['id']) {
                                        echo '<option selected value="' . $j['id'] . '">' . $j['jenis'] . '</option>';
                                    } else {
                                        echo '<option value="' . $j['id'] . '">' . $j['jenis'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="jml" value="<?= $jml ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Upload Bukti</label>
                        <div class="col-sm-4">
                            <input type="file" name="uploadbukti" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="col-sm-5">
                            <a href="<?= base_url($bukti) ?>" target="_blank">Lihat Gambar</a>
                        </div>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary btnsimpan">Update</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function(e) {
    $('.formtambahdata').ajaxForm({
        // dataType: 'json',
        beforeSend: function() {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('Tunggu Sedang di Proses...');
        },
        success: function(data) {
            if (data == 'berhasil') {
                tampildatapengeluaran();
                $('#modaleditdatapengeluaran').modal('hide');
                Swal.fire('Berhasil', 'Data berhasil diupdate', 'success');
            } else {
                Swal.fire('error', data, 'error');
            }
        },
        complete: function() {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Update');
            $('.btnreload').fadeIn('slow');
        },
        error: function(e) {
            Swal.fire(e);
        }
    });
});
</script>