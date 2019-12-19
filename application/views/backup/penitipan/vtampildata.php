<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('penitipan/input', '<i class="fa fa-plus"></i> Input Penitipan', array('class' => 'btn btn-primary')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open('penitipan/data') ?>
                    <div class="input-group mb-3">
                        <input type="text" value="<?= $this->session->userdata('capel') ?>" class="form-control" placeholder="Cari Berdasarkan ID Penitipan / Nama Pelanggan" aria-label="Cari Data" autofocus name="cari">
                        <div class="input-group-append">
                            <button name="btncari" class="btn btn-success btn-outline" type="submit"><i class="fa fa-search"></i> Cari</button>
                        </div>
                    </div>
                    <?= form_close() ?>
                    <p>
                        <h5>Total Data : <?= $totaldata; ?></h5>
                    </p>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Penitipan</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Total Penitipan</th>
                                <th>Status</th>
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
                                        <td><?= $r['penitipanid'] ?></td>
                                        <td><?= $r['tgl'] ?></td>
                                        <td><?= $r['pelanggan'] ?></td>
                                        <td align="right"><?= number_format($r['total']) ?></td>
                                        <td>
                                            <?php 
                                                    if($r['penitipanstt']==1){
                                                        echo '<span class="badge badge-success">Sudah di Ambil</span>';
                                                    }else{
                                                        echo '<span class="badge badge-danger">Belum di Ambil</span>';
                                                    }
                                            ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="hapusdatapenitipan('<?= $r['penitipanid'] ?>');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <script>
                                                function hapusdatapenitipan(id) {
                                                    Swal.fire({
                                                        title: 'Hapus Penitipan',
                                                        text: "Yakin data dengan ID Penitipan : " + id + ", di hapus ? \n Semua Detail Penitipan juga ikut terhapus !",
                                                        type: 'question',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ya, Hapus !',
                                                        cancelButtonText: 'Tidak',
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            location.href = ('<?= site_url('penitipan/hapussemuadata/') ?>' + id);
                                                        }
                                                    })
                                                }
                                            </script>
                                            <button type="button" class="btn btn-outline-info" onclick="window.location.href=('<?= site_url('penitipan/detail/' . $r['penitipanid']) ?>')">
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