<link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/js/jquery.form.js') ?>"></script>
<script src="<?= base_url('assets/novinaldi/scriptpengeluaranmaster.js') ?>"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <button type="button" class="btn btn-primary" onclick="tambahdata();">
                        <i class="fa fw fa-plus"></i> Tambah Pengeluaran
                    </button>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm" id="datapengeluaran" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl.Pengeluaran</th>
                                <th>Nama Pengeluaran</th>
                                <th>Jumlah (Rp)</th>
                                <th>Jenis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="viewtampil" style="display: none;"></div>
            </div>
        </div>
    </div>
</div>