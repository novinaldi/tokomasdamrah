<script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
<script>
    $(document).on('click', '.buatNomor', function(e) {
        let tglpinjam = $('#tglpinjam').val();
        if (tglpinjam == "") {
            Swal.fire('Warning', 'Silahkan Pilih Tanggal Terlebih dahulu', 'warning')
        } else {
            $.ajax({
                url: '<?= site_url('pinjaman/buatnomor') ?>',
                data: "&tgl=" + tglpinjam,
                type: 'post',
                cache: false,
                success: function(data) {
                    $('.nopinjaman').val(data);
                },
                error: function(e) {
                    Swal.fire('Error', 'Ada kesalahan query', 'error');
                }
            })
        }
    });
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pinjaman/data/', '<i class="fa fa-check-square"></i> Lihat Data', array('class' => 'btn btn-primary')) ?>
                </strong>
            </div>
            <div class="card-body">
                <div class="sufee-alert alert with-close alert-primary alert-dismissible fade show">
                    <span class="badge badge-pill badge-primary">Info !!!</span>
                    Silahkan Tambahkan Data Pinjaman Pelanggan Terlebih dahulu
                </div>

                <p>
                    <?= $this->session->flashdata('pesan') ?>
                    <?= form_open('pinjaman/simpandata', array('class' => 'form-horizontal')) ?>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Tgl.Peminjaman</label></div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <input type="date" class="form-control" name="tglpinjam" id="tglpinjam">
                            </p>
                        </div>
                        <div class="col-12 col-md-4">
                            <p class="form-control-static">
                                <button type="button" class="btn btn-primary buatNomor" onclick="buatNomor();">
                                    Buat No.Pinjaman
                                </button>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">No.Pinjaman</label></div>
                        <div class="col-12 col-md-6">
                            <p class="form-control-static">
                                <input type="text" class="form-control nopinjaman" name="nopinjaman" placeholder="Nomor ini otomatis" value="" readonly>
                            </p>
                            <p>
                                <span class="badge badge-info">No.Peminjaman ini otomatis digenerate oleh sistem berdasarkan tanggal pinjaman</span>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Cari Pelanggan</label></label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <input type="text" readonly class="form-control" id="nikpelanggan" name="nikpelanggan" placeholder="NIK Pelanggan">
                            </p>
                        </div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <button type="button" class="btn btn-success" onclick="javascript: tampildatapelanggan('<?= site_url('pinjaman/caripelanggan') ?>');">
                                    Cari
                                </button>
                                <script type="text/javascript" language="javascript">
                                    var newwindow;

                                    function tampildatapelanggan(url) {
                                        newwindow = window.open(url, 'Data Pelanggan', 'width=800, height=700, menubar=yes,location=yes,scrollbars=yes, resizeable=no, status=yes, copyhistory=no,toolbar=no');
                                        if (window.focus) {
                                            newwindow.focus()
                                        }
                                        return false;
                                    }
                                </script>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label"></label></label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <input type="text" class="form-control" id="namapelanggan" name="namapelanggan" placeholder="Nama Pelanggan" readonly>
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label">Jumlah Pinjaman (Gram)</label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <input type="text" class="form-control" name="jmlpinjam">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3"><label class=" form-control-label"></label></label></div>
                        <div class="col-12 col-md-3">
                            <p class="form-control-static">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Simpan
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