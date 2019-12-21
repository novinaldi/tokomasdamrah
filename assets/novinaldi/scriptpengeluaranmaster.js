function tambahdata() {
    $.ajax({
        url: './tambahdatapengeluaran',
        success: function (data) {
            $('.viewtampil').show();
            $('.viewtampil').html(data);
            $('#modaltambahdatapengeluaran').modal('show');
        }
    });
}
function tampildatapengeluaran() {
    table = $('#datapengeluaran').DataTable({
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "./ambildatapengeluaran",
            "type": "POST"
        },


        "columnDefs": [{
            "targets": [0],
            "orderable": false,
        },
        {
            "targets": [3],
            "orderable": false,
            "className": "text-right"
        },
        {
            "targets": [5],
            "orderable": false
        }
        ],

    });
}
$(document).ready(function (e) {
    tampildatapengeluaran();
});

// $(document).on('ajaxForm', '.formtambahdata', function (e) {
//     $.ajax({
//         type: "post",
//         url: $(this).attr('action'),
//         data: $(this).serialize(),
//         cache: false,
//         success: function (data) {
//             Swal.fire(data);
//         }
//     });
//     return false;

// })