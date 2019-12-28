<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    Silahkan Ganti Password Anda dengan mengisi form berikut
                </h6>
            </div>
            <div class="card-body">
                <?= form_open('gantipassword/change', ['class' => 'form']) ?>
                <div class="pesan" style="display: none;"></div>
                <div class="row form-group">
                    <label class="col-sm-3 col-form-label" for="passlama">Input Password Lama</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="passlama" id="passlama" autofocus>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-3 col-form-label" for="passbaru">Input Password Baru</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="passbaru" id="passbaru">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-3 col-form-label" for="ulangipassbaru">Ulangi Input Password Baru</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="ulangipassbaru" id="ulangipassbaru">
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success btnsimpan">
                            Update Password
                        </button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
            <script>
            $(document).on('submit', '.form', function(e) {
                $.ajax({
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    type: "post",
                    dataType: 'json',
                    cache: false,
                    beforeSend: function(e) {
                        $('.btnsimpan').attr('disabled', 'disabled');
                        $('.btnsimpan').html(
                            '<i class="fa fa-spin fa-spinner"></i> Tunggu Sebentar');
                    },
                    success: function(data) {
                        $('.pesan').fadeIn();
                        if (data.sukses) {
                            let timerInterval
                            Swal.fire({
                                title: 'Password anda berhasil diganti, Anda di arahkan ke login',
                                html: 'Silahkan tunggu dalam <b></b> milliseconds.',
                                timer: 2000,
                                timerProgressBar: true,
                                onBeforeOpen: () => {
                                    Swal.showLoading()
                                    timerInterval = setInterval(() => {
                                        Swal.getContent().querySelector('b')
                                            .textContent = Swal.getTimerLeft()
                                    }, 100)
                                },
                                onClose: () => {
                                    clearInterval(timerInterval)
                                }
                            }).then((result) => {
                                if (
                                    /* Read more about handling dismissals below */
                                    result.dismiss === Swal.DismissReason.timer

                                ) {
                                    window.location.href = (
                                        "<?= site_url('login/index') ?>");
                                }
                            })
                        }
                        if (data.error) {
                            $('.pesan').html(data.error);
                        }
                    },
                    complete: function() {
                        $('.btnsimpan').removeAttr('disabled');
                        $('.btnsimpan').html('Update Password');
                    }
                });
                return false;
            });
            </script>
        </div>
    </div>
</div>