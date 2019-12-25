<script>
$(document).on('click', '.btnpengeluaran', function(e) {
    url = './pengeluaran';
    window.open(url);
});
$(document).on('click', '.btnpenitipanuang', function(e) {
    url = './penitipanuang';
    window.open(url);
});
$(document).on('click', '.btnpenitipanemas', function(e) {
    url = './penitipanemas';
    window.open(url);
});
$(document).on('click', '.btnpeminjamanuang', function(e) {
    url = './peminjamanuang';
    window.open(url);
});
$(document).on('click', '.btnpeminjamanemas', function(e) {
    url = './peminjamanemas';
    window.open(url);
});
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title"></strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2 btnpengeluaran" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-primary text-uppercase mb-1">
                                            Pengeluaran
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-file fa-3x text-primary-300" style="color: blue;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2 btnpenitipanuang"
                            style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-success text-uppercase mb-1">Penitipan
                                            uang</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-3x text-success-300" style="color: green;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2 btnpenitipanemas"
                            style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-danger text-uppercase mb-1">Penitipan
                                            Emas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-ring fa-3x text-danger-300" style="color: red;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2 btnpeminjamanuang"
                            style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-warning text-uppercase mb-1">
                                            Peminjaman
                                            Uang</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-dollar-sign fa-3x text-warning-300" style="color: orange;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2 btnpeminjamanemas" style="cursor: pointer;">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-md font-weight-bold text-info text-uppercase mb-1">
                                            Peminjaman
                                            Emas</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-ring fa-3x text-info-300" style="color: purple;"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>