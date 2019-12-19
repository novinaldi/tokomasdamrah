<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<script>
    function readURL(input) { 
        if (input.files && input.files[0]) {
            var reader = new FileReader(); 

            reader.onload = function(e) { 
                $('#preview_gambar') 
                    .attr('src', e.target.result)
                    .width(150); 
                //.height(200); // Jika ingin menentukan lebar gambar silahkan aktifkan perintah pada baris ini
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pelanggan/detail/' . $nik, '<i class="fa fa-hand-o-left"></i> Kembali', array('class' => 'btn btn-warning')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= form_open_multipart('pelanggan/doupload', array('class' => 'form-horizontal')) ?>
                    <input type="hidden" name="nik" value="<?= $nik; ?>">
                    <?= $this->session->flashdata('pesan'); ?>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Upload Foto KTP</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input type="file" name="uploadktp" accept=".jpg,.png,.jpeg" required onchange="readURL(this);">
                            </p>
                            <p>
                                <img id="preview_gambar" src="#" alt="Gambar Anda" />
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label"></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-upload"></i> Upload Foto
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