<script>
    function hapus(id) {
        Swal.fire({
            title: 'Hapus Pengeluaran',
            text: "Yakin di hapus ?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                location.href = ('<?= site_url('pengeluaran/hapusdata/') ?>' + id);
            }
        })
    }
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pengeluaran/tambah', '<i class="fa fa-plus"></i> Tambah Data', array('class' => 'btn btn-primary')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open('pengeluaran/index') ?>
                    <div class="input-group mb-3">
                        <input type="text" value="<?= $this->session->userdata('capel') ?>" class="form-control" placeholder="Cari Berdasarkan Tanggal/Nama Pengeluaran" aria-label="Cari Data" autofocus name="cari">
                        <div class="input-group-append">
                            <button name="btncari" class="btn btn-success btn-outline" type="submit"><i class="fa fa-search"></i> Cari</button>
                        </div>

                    </div>
                    <p>
                        <span class="badge badge-info">Untuk Mencari Berdasarkan Tanggal, input dengan format : yyyy-mm-dd</span>
                    </p>
                    <?= form_close() ?>
                    <p>
                        <h5>Total Data : <?= $totaldata; ?></h5>
                    </p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pengeluaran</th>
                                <th>Tanggal</th>
                                <th>Jumlah (Rp)</th>
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
                                        <td><?= $r['namapengeluaran'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($r['tglpengeluaran'])) ?></td>
                                        <td align="right"><?= number_format($r['jmlpengeluaran'], 0) ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="return hapus('<?= $r['id'] ?>')">
                                                <i class="fa fa-trash"></i>
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