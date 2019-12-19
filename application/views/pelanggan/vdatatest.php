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
                "url": "<?php echo site_url('pelanggan2/ambildata') ?>",
                "type": "POST"
            },


            "columnDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],

        });
    });
</script>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Test dataTable</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataPelanggan" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Jenkel</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>