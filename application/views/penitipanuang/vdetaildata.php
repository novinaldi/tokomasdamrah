<script>
$(function() {
    $('[data-toggle="tooltip"]').tooltip()
});
</script>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">
                    <?= anchor('penitipan-uang/data', '<i class="fa fa-backspace"></i> Kembali', array('class' => 'btn btn-outline-warning')) ?>

                </h6>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <table class="table table-striped table-sm">
                            <tr>
                                <td>Nomor Penitipan</td>
                                <td>:</td>
                                <td>
                                    <?= $notitip; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Tgl.Awal Penitipan</td>
                                <td>:</td>
                                <td><?= $tgl ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col">
                        <table class="table table-striped table-sm">
                            <tr>
                                <td>Pelanggan</td>
                                <td>:</td>
                                <td><?= $pelanggan ?></td>
                            </tr>
                            <tr>
                                <td>Sisa Penitipan (Rp)</td>
                                <td>:</td>
                                <td align="right">
                                    <h3><span class="badge badge-info"><?= $sisa; ?></span></h3>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <?php
                if ($stt == 0) {
                ?>
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary btn-block"
                            onclick="tambahpenitipan('<?= $notitip; ?>')">
                            Tambah Titipan
                        </button>
                        <script>
                        function tambahpenitipan(notitip) {
                            $.ajax({
                                url: "<?= site_url('penitipan_uang/formtambahpenitipan') ?>",
                                data: "&notitip=" + notitip,
                                type: 'post',
                                cache: false,
                                success: function(data) {
                                    $('.formtambahdata').show();
                                    $('.formtambahdata').html(data);
                                    $('#modalformtambahdata').modal('show');
                                }
                            });
                        }
                        </script>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-info btn-block"
                            onclick="tambahpengambilan('<?= $notitip; ?>')">
                            Tambah Pengambilan
                        </button>
                        <script>
                        function tambahpengambilan(notitip) {
                            $.ajax({
                                url: "<?= site_url('penitipan_uang/formtambahpengambilan') ?>",
                                data: "&notitip=" + notitip,
                                type: 'post',
                                cache: false,
                                success: function(data) {
                                    $('.formtambahdata').show();
                                    $('.formtambahdata').html(data);
                                    $('#modalformtambahdata').modal('show');
                                }
                            });
                        }
                        </script>
                    </div>
                </div>
                <?php
                } else {
                ?>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-info text-center">
                            <h5>Titipan Sudah di Ambil Semua...</h5>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
                <p>
                    <?= $this->session->flashdata('validasi') ?>
                </p>
                <div class="formtambahdata" style="display:none;"></div>
            </div>
        </div>
    </div>
</div>
<!-- Data -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-success">
                <h6 class="m-0 font-weight-bold text-white">
                    Data Detail Penitipan
                </h6>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?php
                $querydata = "SELECT a.iddetail AS id, a.`notitip` AS notitip,a.`tgl` AS tgl,
                            CASE a.`pilihan` WHEN 1 THEN nominal ELSE 0 END AS titipan,
                            CASE a.`pilihan` WHEN 2 THEN nominal ELSE 0 END AS ambil,
                            a.buktifoto, a.ket
                            FROM nn_detailtitipuang a WHERE a.notitip = '$notitip' ORDER BY tgl ASC";
                //Pagination
                $query_data = $this->db->query($querydata);
                $total_data = $query_data->num_rows();
                //Ini Konfigurasi Pagination
                $config['base_url'] = site_url('penitipan-uang/detaildata/' . $notitip . '/');
                $config['total_rows'] = $total_data;
                $config['per_page'] = '20';
                $config['next_link'] = 'Next';
                $config['prev_link'] = 'Previous';
                $config['first_link'] = 'Awal';
                $config['last_link'] = 'Akhir';
                $config['uri_segment'] = 4;

                //Custom Pagination
                // Membuat Style pagination untuk BootStrap v4
                $config['first_link']       = 'First';
                $config['last_link']        = 'Last';
                $config['next_link']        = 'Next';
                $config['prev_link']        = 'Prev';
                $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
                $config['full_tag_close']   = '</ul></nav></div>';
                $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
                $config['num_tag_close']    = '</span></li>';
                $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
                $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
                $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
                $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
                $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
                $config['prev_tagl_close']  = '</span>Next</li>';
                $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
                $config['first_tagl_close'] = '</span></li>';
                $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
                $config['last_tagl_close']  = '</span></li>';
                //custom pagination

                $this->pagination->initialize($config);
                //End

                $uri = $this->uri->segment(4);
                $per_page = $config['per_page'];

                if ($uri == null) {
                    $start = 0;
                } else {
                    $start = $uri;
                }
                //Query data perpage


                $qx = "SELECT a.iddetail AS id, a.`notitip` AS notitip,a.`tgl` AS tgl,
                CASE a.`pilihan` WHEN 1 THEN nominal ELSE 0 END AS titipan,
                CASE a.`pilihan` WHEN 2 THEN nominal ELSE 0 END AS ambil,
                a.buktifoto, a.ket
                FROM nn_detailtitipuang a WHERE a.notitip = '$notitip' ORDER BY tgl ASC LIMIT " . $start . ',' . $per_page;

                //end Pagination


                $datadetail = $this->db->query($qx);
                // $totaldata = $datadetail->num_rows();
                $totaldata = $config['total_rows'];
                $nomor = 0;
                ?>
                <h5>Total Data : <?= $totaldata ?></h5>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl</th>
                            <th>Penitipan</th>
                            <th>Pengambilan</th>
                            <th>Saldo</th>
                            <th>Keterangan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($totaldata > 0) {
                            $jumlahsaldo = 0;
                            foreach ($datadetail->result_array() as $row) {
                                $nomor++;
                                $jumlahsaldo = ($jumlahsaldo + $row['titipan']) - $row['ambil'];
                        ?>
                        <tr>
                            <td><?= $nomor; ?></td>
                            <td><?= date('d-m-Y', strtotime($row['tgl'])) ?></td>
                            <td align="right"><?= number_format($row['titipan'], 0) ?></td>
                            <td align="right"><?= number_format($row['ambil'], 0) ?></td>
                            <td align="right"><?= number_format($jumlahsaldo, 0) ?></td>
                            <td>
                                <?php
                                        echo $row['ket'];
                                        if ($row['buktifoto'] != NULL) {
                                        ?>
                                <p>
                                    <button type="button" class="btn btn-outline-info"
                                        onclick="lihatbuktipenitipan('<?= $row['id'] ?>')">Lihat Bukti</button>
                                </p>
                                <?php
                                        }
                                        ?>
                            </td>
                            <td>
                                <button type="button" onclick="hapusdetail('<?= $row['id'] ?>','<?= $notitip ?>');"
                                    class="btn btn-outline-danger" data-toggle="tooltip" data-placement="top"
                                    title="Hapus Data Detail Penitipan">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php
                            }
                            ?>
                        <tr>
                            <td></td>
                        </tr>
                        <?php
                        } else {
                            echo '<tr><th colspan="7">Data belum ada...</th></tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <?= $this->pagination->create_links(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="tampildetailbuktifoto" style="display:none;"></div>
<script>
function hapusdetail(id, notitip) {
    Swal.fire({
        title: 'Hapus Detail',
        text: "Yakin hapus data ini ?",
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Hapus !',
        cancelButtonText: 'Tidak',
    }).then((result) => {
        if (result.value) {
            location.href = ("<?= site_url('penitipan-uang/hapusdetaildata/') ?>" + id + "/" + notitip);
        }
    })
}

function lihatbuktipenitipan(id) {
    $.ajax({
        url: "<?= site_url('penitipan-uang/tampilkanbuktifoto') ?>",
        data: "&id=" + id,
        type: 'post',
        cache: false,
        success: function(data) {
            $('.tampildetailbuktifoto').show();
            $('.tampildetailbuktifoto').html(data);
            $('#modaltampildetailbuktifoto').modal('show');
        }
    });
}
</script>