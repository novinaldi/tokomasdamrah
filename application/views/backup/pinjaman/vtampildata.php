<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pinjaman/input', '<i class="fa fa-plus"></i> Input Pinjaman', array('class' => 'btn btn-primary')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= $this->session->flashdata('pesan'); ?>
                    <?= form_open('pinjaman/data') ?>
                    <div class="input-group mb-3">
                        <input type="text" value="<?= $this->session->userdata('capel') ?>" class="form-control" placeholder="Cari Berdasarkan ID Pinjaman / Tanggal Pinjaman / Nama Pelanggan" aria-label="Cari Data" autofocus name="cari">
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
                                <th>ID Pinjaman</th>
                                <th>Tanggal</th>
                                <th>Pelanggan</th>
                                <th>Jumlah Pinjaman (Gram)</th>
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
                                        <td><?= $r['pinjamanno'] ?></td>
                                        <td><?= date('d-m-Y', strtotime($r['pinjamantgl'])) ?></td>
                                        <td><?= $r['pinjamanpelnik'] . ' / ' . $r['pelnama'] ?></td>
                                        <td align="right"><?= number_format($r['pinjamanjml']) ?></td>
                                        <td>
                                            <?php
                                                    if ($r['pinjamanstt'] == 1) {
                                                        echo '<span class="badge badge-success">Sudah di Lunas</span>';
                                                    } else {
                                                        echo '<span class="badge badge-danger">Belum di Lunas</span>';
                                                    }
                                                    ?>                                                    
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger" onclick="hapusdata('<?= $r['pinjamanno'] ?>');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                            <script>
                                                function hapusdata(no) {
                                                    Swal.fire({
                                                        title: 'Hapus Pinjaman',
                                                        text: "Yakin data dengan No.Pinjaman : " + no + ", di hapus ?",
                                                        type: 'question',
                                                        showCancelButton: true,
                                                        confirmButtonColor: '#3085d6',
                                                        cancelButtonColor: '#d33',
                                                        confirmButtonText: 'Ya, Hapus !',
                                                        cancelButtonText: 'Tidak',
                                                    }).then((result) => {
                                                        if (result.value) {
                                                            location.href = ('<?= site_url('pinjaman/hapusdata/') ?>' + no);
                                                        }
                                                    })
                                                }
                                            </script>
                                            <button type="button" class="btn btn-info" onclick="edit('<?= $r['pinjamanno'] ?>')">
                                                <i class="fa fa-pencil"></i>
                                            </button>
                                            <script>
                                                function edit(no) {
                                                    location.href = ('<?= site_url('pinjaman/edit/') ?>' + no);
                                                }
                                            </script>
                                            <button type="button" class="btn btn-outline-success" onclick="pembayaran('<?= $r['pinjamanno'] ?>')">
                                                <i class="fa fa-share"></i>
                                            </button>
                                            <script>
                                                function pembayaran(no) {
                                                    location.href = ('<?= site_url('pinjaman/pembayaran/') ?>' + no);
                                                }
                                            </script>
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