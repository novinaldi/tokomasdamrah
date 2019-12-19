<script>
    function hapus(nik) {
        Swal.fire({
            title: 'Hapus Pelanggan',
            text: "Yakin data NIK = " + nik + " di hapus ?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                location.href = ('<?= site_url('pelanggan/hapusdata/') ?>' + nik);
            }
        })
    }
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <?= anchor('pelanggan/tambah', '<i class="fa fa-plus"></i> Tambah Data', array('class' => 'btn btn-primary')) ?>

                </h6>
            </div>
            <div class="card-body">

                <p>
                    <?= $this->session->flashdata('pesan'); ?>
                    <p>
                        <?= form_open('pelanggan/index') ?>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Cari Data Berdasarkan NIK / Nama Pelanggan" name="cari" autofocus="autofocus" autocomplete="off" value="<?= $this->session->userdata('capel') ?>">
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" type="submit" name="btncari"><i class="fa fa-search-plus"></i></button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </p>
                    <p>
                        <h5>Total Data : <?= $totaldata; ?></h5>
                    </p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIK</th>
                                <th>Nama Pelanggan</th>
                                <th>Jenkel</th>
                                <th>Alamat</th>
                                <th>No.Hp/Telp</th>
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
                                            <?php
                                                    if ($r['peljk'] == 'L')
                                                        echo 'Laki-Laki';
                                                    else echo 'Perempuan';
                                                    ?>
                                        </td>
                                        <td><?= $r['pelalamat'] ?></td>
                                        <td><?= $r['pelnohp'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="return hapus('<?= $r['pelnik'] ?>')">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
                                            <button type="button" class="btn btn-info" onclick="window.location.href=('<?= site_url('pelanggan/detail/' . $r['pelnik']) ?>')">
                                                Detail
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
                </p>
                <p>

                    <?= $this->pagination->create_links(); ?>

                </p>

            </div>
        </div>
    </div>
</div>