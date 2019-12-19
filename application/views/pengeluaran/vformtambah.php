<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <?= anchor('pengeluaran/index', '<i class="fa fa-hand-o-left"></i> Kembali', array('class' => 'btn btn-warning')) ?>
                </strong>
            </div>
            <div class="card-body">
                <p>
                    <?= form_open('pengeluaran/simpandata', array('class' => 'form-horizontal')) ?>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Nama Pengeluaran</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input type="text" required name="namapengeluaran" class="form-control" autofocus autocomplete="off">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Tanggal Pengeluaran</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input type="date" required name="tgl" class="form-control">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label">Jumlah Pengeluaran (Rp)</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <input type="number" required name="jml" class="form-control">
                            </p>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label class=" form-control-label"></label>
                        </div>
                        <div class="col-12 col-md-9">
                            <p class="form-control-static">
                                <?= form_submit('simpan', 'Simpan Data', array('class' => 'btn btn-success')) ?>
                            </p>
                        </div>
                    </div>
                    <?= form_close(); ?>
                </p>
            </div>
        </div>
    </div>
</div>