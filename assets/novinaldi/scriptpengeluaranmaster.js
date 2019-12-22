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
function hapus(id) {
    Swal.fire({
        title: 'Hapus Pengeluaran',
        text: "Yakin data ini dihapus ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes !'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "post",
                url: "./hapusdata",
                data: "&id=" + id,
                cache: false,
                success: function (data) {
                    Swal.fire(
                        'Deleted!',
                        'data berhasil terhapus',
                        'success'
                    );
                    tampildatapengeluaran();
                },
                error: function (e) {
                    Swal.fire('Error', e, 'error');
                }
            });
        }
    })
}

function edit(id) {
    $.ajax({
        type: "post",
        url: "./edit",
        data: "&id=" + id,
        cache: false,
        success: function (data) {
            $('.viewtampil').show();
            $('.viewtampil').html(data);
            $('#modaleditdatapengeluaran').modal('show');

        }, error: function (e) {
            Swal.fire(
                'Error !',
                e, 'error'
            );
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