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
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
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
                                <input type="file" name="uploadktp" accept=".jpg,.png,.jpeg" onchange="readURL(this);">
                            </p>
                            <p>
                                <img id="preview_gambar" src="#" alt="Gambar Anda" />
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-9">
                            <div class="alert alert-info">
                                <h3>Atau Ambil Gambar Dengan WebCam</h3>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-4">
                            <div id="my_camera">

                            </div>
                            <p>
                                <input type="button" value="Take Picture" class="btn btn-info"
                                    onclick="take_picture();">
                            </p>
                        </div>
                        <div class="col col-md-6">
                            <div id="results">Your captured image will appear here...</div>
                            <input type="hidden" name="imagecam" class="image-tag">
                        </div>
                        <script language="JavaScript">
                        Webcam.set({
                            width: 320,
                            height: 240,
                            image_format: 'jpeg',
                            jpeg_quality: 100
                        });
                        Webcam.attach('#my_camera');

                        function take_picture() {
                            Webcam.snap(function(data_uri) {
                                $(".image-tag").val(data_uri);

                                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';

                            });
                        }
                        </script>
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