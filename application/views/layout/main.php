<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Halaman User | Sistem Informasi Toko Mas H.Damrah</title>
    <meta name="description" content="Sistem Informasi Toko Mas H.Damrah">
    <meta name="viewport" content="Sistem Informasi Toko Mas H.Damrah">

    <link rel="apple-touch-icon" href="">
    <link rel="shortcut icon" href="">

    <?php $link = base_url('temp/') ?>
    <link rel="stylesheet" href="<?= $link ?>vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= $link ?>vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= $link ?>vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= $link ?>vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= $link ?>vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="<?= $link ?>assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <script src="<?= base_url('temp/') ?>assets/js/jquery.min.js"></script>
    <script src="<?= base_url('temp/') ?>vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url('temp/') ?>vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url('temp/') ?>assets/js/main.js"></script>

    <!-- Sweet Alert -->
    <script src="<?= base_url('temp/') ?>plugins/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('temp/') ?>plugins/node_modules/sweetalert2/dist/sweetalert2.min.css">
</head>

<body>
    <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#">Mas H.Damrah</a>
                <a class="navbar-brand hidden" href="#">DM</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="<?php if ($this->uri->segment(1) == 'home') echo 'active'; ?>">
                        <a href="<?= site_url('home/index') ?>"> <i class="menu-icon fa fa-dashboard"></i>Home </a>
                    </li>
                    <h3 class="menu-title">Menu Utama</h3><!-- /.menu-title -->
                    <li class="<?php if ($this->uri->segment(1) == 'pelanggan') echo 'active'; ?>">
                        <a href="<?= site_url('pelanggan/index') ?>"> <i class="menu-icon fa fa-users"></i>Manajemen Pelanggan </a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Penitipan</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-money"></i><a href="<?= site_url('penitipan/input') ?>">Input</a></li>

                            <li><i class="fa fa-money"></i><a href="<?= site_url('penitipan/data') ?>">Data</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-money"></i>Pinjaman</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="<?= site_url('pinjaman/input') ?>">Input</a></li>
                            <li><i class="fa fa-table"></i><a href="<?= site_url('pinjaman/data') ?>">Data</a></li>
                        </ul>
                    </li>
                    <li class="<?php if ($this->uri->segment(1) == 'pengeluaran') echo 'active'; ?>">
                        <a href="<?= site_url('pengeluaran/index') ?>"> <i class="menu-icon fa fa-table"></i>Pengeluaran </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">

                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="user-avatar rounded-circle" src="<?= $link ?>images/admin.jpg" alt="">
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="#"><i class="fa fa-user"></i> Profil</a>

                            <a class="nav-link" href="<?= site_url('login/keluar') ?>"><i class="fa fa-power-off"></i> Logout</a>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>{judul}</h1>
                    </div>
                </div>
            </div>

        </div>

        <div class="content mt-3">
            <div class="animated fadeIn">
                {isi}
            </div><!-- .animated -->
        </div><!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->


</body>

</html>