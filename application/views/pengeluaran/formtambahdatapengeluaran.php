<div class="modal fade" id="modaltambahdatapengeluaran" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="exampleModalLongTitle">Form Tambah Data Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= form_open_multipart('pengeluaran/simpandatapengeluaran', ['class' => 'formtambahdata']) ?>
            <div class="modal-body">
                <div class="pesan" style="display: none;"></div>
                <p>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tgl. Pengeluaran</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" name="tgl">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Pengeluaran</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jumlah (Rp)</label>
                        <div class="col-sm-5">
                            <input type="number" class="form-control" name="jml">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Upload Bukti</label>
                        <div class="col-sm-4">
                            <input type="file" name="uploadbukti" accept=".jpg,.jpeg,.png">
                        </div>
                        <div class="col-sm-5">
                            <span class="badge badge-info">Upload Bukti Pengeluaran, Jika Ada...</span>
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
<script>
$(document).ready(function(e) {
    $('.formtambahdata').ajaxForm({
        // dataType: 'json',
        beforeSend: function() {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('Tunggu Sedang di Proses...');
        },
        success: function(data) {
            alert(data);
        },
        complete: function() {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan');
            $('.btnreload').fadeIn('slow');
        },
        error: function(e) {
            alert(e);
        }
    });
});
</script>