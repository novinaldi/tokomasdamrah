<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-outline-primary" onclick="window.location.href=('<?= site_url('peminjamanemas/') ?>')">
                        <i class="fa fa-plus"></i> Input Data</button>
                </h6>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <p>
                    <?= form_open('peminjamanemas/data') ?>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Cari Data Berdasarkan No.Peminjaman / NIK / Nama Pelanggan" name="cari" autofocus="autofocus" autocomplete="off" value="<?= $this->session->userdata('caripeminjamanemas') ?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success" type="submit" name="btncari">
                                <i class="fa fa-search-plus"></i> Cari
                            </button>
                        </div>
                    </div>
                    <?= form_close() ?>
                </p>
                <h5>Total Data : <?= $totaldata; ?></h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="width:4%;">No</th>
                            <th style="width:16%;">No.Peminjaman</th>
                            <th>Tgl.Awal Peminjaman</th>
                            <th>Pelanggan</th>
                            <th>Total Pinjaman (Gram)</th>
                            <th>Total Bayar (Gram)</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $nomor = 0 + $this->uri->segment(3);
                        if ($tampildata->num_rows() > 0) {
                            foreach ($tampildata->result_array() as $d) {
                                $nomor++;
                                ?>
                                <tr>
                                    <td><?= $nomor; ?></td>
                                    <td><?= $d['nomor'] ?></td>
                                    <td><?= $d['tglawal'] ?></td>
                                    <td><?= $d['nikpel'] . ' / ' . $d['pelnama'] ?></td>
                                    <td align="right"><?= number_format($d['jmltotalpinjam'], 2, ",", ".") ?></td>
                                    <td align="right"><?= number_format($d['jmltotalbayar'], 2, ",", ".") ?></td>
                                    <td>
                                        <?php
                                                $sisa = $d['jmltotalpinjam'] - $d['jmltotalbayar'];
                                                if ($sisa == 0) {
                                                    echo '<span class="badge badge-success">Sudah Lunas</span>';
                                                } else {
                                                    echo '<span class="badge badge-danger">Belum Lunas</span>';
                                                }
                                                ?>
                                    </td>
                                    <td>
                                        <p>

                                            <button onclick="hapusdata('<?= $d['nomor'] ?>')" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>

                                        </p>
                                        <p>
                                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Detail Data" onclick="window.location.href=('<?= site_url('peminjamanemas/detaildata/' . $d['nomor']) ?>')">
                                                <i class="fa fa-share"></i>
                                            </button>
                                        </p>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <p>
                    <?= $this->pagination->create_links(); ?>
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    function hapusdata(no) {
        Swal.fire({
            title: 'Hapus Peminjaman Emas',
            text: "Yakin hapus data ini, semua detail yang ada juga ikut terhapus ?",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            if (result.value) {
                location.href = ('<?= site_url('peminjamanemas/hapusdata/') ?>' + no);
            }
        })
    }
</script>