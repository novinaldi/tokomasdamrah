<link href="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="<?= base_url('assets/') ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/') ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
        // $('#dataPelanggan').DataTable();
        //datatables
        table = $('#dataPelanggan').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo site_url('peminjamanemas/ambildatapelanggan') ?>",
                "type": "POST"
            },


            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],

        });
    });

    function pilihdata(nik) {
        $('input[name="nikpel"]').val(nik);

        $.ajax({
            url: '<?= site_url('peminjamanemas/ambildetailpelanggan') ?>',
            type: 'post',
            data: "&nik=" + nik,
            dataType: 'json',
            cache: false,
            success: function(data) {
                $('input[name="namapel"]').val(data.namapelanggan);
            },
            error: function(e) {
                Swal.fire('Error', e, 'error');
            }
        })

        $('#modalcaripelanggan').modal('hide');
        $('.caripelanggan').hide();
    }
</script>

<div class="modal fade" id="modalcaripelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Silahkan Cari Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataPelanggan" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>