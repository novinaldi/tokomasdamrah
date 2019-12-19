<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <?php $link = base_url('temp/') ?>
    <link rel="stylesheet" href="<?= $link ?>vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $link ?>vendors/font-awesome/css/font-awesome.min.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url('temp/') ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <title>Cari Data Pelanggan</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Data Pelanggan</a>

    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">
                            Silahkan Cari Data Pelanggan
                        </strong>
                    </div>
                    <div class="card-body">
                        <p>
                            <div class="table table-responsive">
                                <?= $this->session->flashdata('pesan'); ?>
                                <?= form_open() ?>
                                <div class="input-group mb-3">
                                    <input type="text" value="<?= $this->session->userdata('capel') ?>" class="form-control" placeholder="Cari Berdasarkan NIK / Nama Pelanggan" aria-label="Cari Data" autofocus name="cari">
                                    <div class="input-group-append">
                                        <button name="btncari" class="btn btn-success btn-outline" type="submit"><i class="fa fa-search"></i> Cari</button>
                                    </div>
                                </div>
                                <?= form_close() ?>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>NIK</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = 1 + $this->uri->segment(3);
                                        if ($tampildata->num_rows() > 0) {
                                            foreach ($tampildata->result_array() as $r) {

                                                ?>
                                                <tr>
                                                    <th><?= $nomor ?></th>
                                                    <td><?= $r['pelnik'] ?></td>
                                                    <td><?= $r['pelnama'] ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary" onclick="javascript:pilihdata('<?= $r['pelnik'] ?>','<?= $r['pelnama'] ?>')">
                                                            Pilih
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php
                                                $nomor++;
                                            }
                                        } else {
                                            echo '<tr>
                                    <td colspan="6">Data tidak ditemukan</td>
                                </tr>';
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </p>
                        <p>

                            <?= $this->pagination->create_links(); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function pilihdata(nik,nama){
        opener.document.getElementById('nikpelanggan').value=nik;
        opener.document.getElementById('namapelanggan').value=nama;
        self.close();
    }
    </script>
</body>

</html>