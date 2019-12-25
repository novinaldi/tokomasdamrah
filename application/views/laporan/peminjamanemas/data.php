<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Rekapitulasi Peminjaman Emas || Toko Mas Damrah</title>
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <div class="container">
            <a class="navbar-brand" href="#">Toko Mas Damrah</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container mt-2" style="padding-bottom:100px;">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-warning" onclick="window.close();"><i
                        class="fa fw fa-backward"></i>
                    Kembali</button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">
                            Rekapitulasi Peminjaman Emas Pelanggan | Pilih Periode Tanggal Cetak
                        </h6>
                    </div>
                    <div class="card-body">
                        <?= form_open('report/tampillappeminjamanemas', ['class' => 'formlaporan']) ?>
                        <div class="row form-group">
                            <label class="col-sm-1 col-form-label" for="tglawal">Tgl.Awal</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tglawal" id="tglawal" autofocus>
                            </div>
                            <label class="col-sm-1 col-form-label" for="tglakhir">Tgl.Akhir</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control" name="tglakhir" id="tglakhir">
                            </div>
                            <button type="submit" class="btn btn-success btntampil">
                                Tampilkan
                            </button>
                        </div>
                        <?= form_close(); ?>
                        <script>
                        $(document).on('submit', '.formlaporan', function(e) {
                            $.ajax({
                                url: $(this).attr('action'),
                                data: $(this).serialize(),
                                type: "post",
                                cache: false,
                                beforeSend: function(e) {
                                    $('.btntampil').attr('disabled', 'disabled');
                                    $('.btntampil').html(
                                        '<i class="fa fa-spin fa-spinner"></i> Tunggu Sebentar');
                                },
                                success: function(response) {
                                    $('.tampildata').fadeIn();
                                    $('.tampildata').html(response);
                                },
                                complete: function() {
                                    $('.btntampil').removeAttr('disabled');
                                    $('.btntampil').html('Tampilkan');
                                }
                            });
                            return false;
                        });
                        </script>
                        <div class="row tampildata" style="display: none;"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>