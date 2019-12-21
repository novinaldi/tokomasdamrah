function tambahdata() {
    $.ajax({
        url: './tambahdatajenis',
        success: function (data) {
            $('.viewtampil').show();
            $('.viewtampil').html(data);
            $('#modaltambahdata').modal('show');
        }
    });
}
function hapus(id) {
    Swal.fire({
        title: 'Hapus Jenis Pengeluaran',
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
                url: "./hapusjenis",
                data: "&id=" + id,
                cache: false,
                success: function (response) {
                    Swal.fire(
                        'Deleted!',
                        'data berhasil terhapus',
                        'success'
                    );
                    tampildatajenispengeluaran();
                },
                error: function (e) {
                    Swal.fire('Error', e, 'error');
                }
            });
        }
    })
}
$(document).on('submit', '.formtambahjenis', function (e) {
    $.ajax({
        url: $(this).attr('action'),
        data: $(this).serialize(),
        type: 'post',
        dataType: 'json',
        cache: false,
        beforeSend: function (e) {
            $('.btnsimpan').attr('disabled', 'disabled');
            $('.btnsimpan').html('<i class="fa fa-spinner fa-spin"></i> Sedang di Proses');
        },
        success: function (data) {
            $('.pesan').fadeIn();
            if (data.error) {
                $('.pesan').html(data.error);
            }
            if (data.sukses) {
                $('#modaltambahdata').modal('hide');
                Swal.fire('Berhasil', data.sukses, 'success');
                return tampildatajenispengeluaran();
            }

        },
        complete: function (e) {
            $('.btnsimpan').removeAttr('disabled');
            $('.btnsimpan').html('Simpan');
        },
        error: function (e) {
            Swal.fire(e);
        }
    });
    return false;
});