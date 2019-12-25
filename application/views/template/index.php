<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Halaman User | Sistem Informasi Pengolahan Data Toko Mas H.Damrah Solok</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/') ?>css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Sweet Alert -->
    <script src="<?= base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/') ?>vendor/sweetalert2/dist/sweetalert2.min.css">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center"
                href="<?= site_url('home/index') ?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-ring"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Mas Damrah <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php if ($this->uri->segment(1) == 'home') echo 'active'; ?>">
                <a class="nav-link" href="<?= site_url('home/index') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                File Master
            </div>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'pelanggan') echo 'active'; ?>">
                <a class="nav-link" href="<?= site_url('pelanggan') ?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Pelanggan</span></a>
            </li>
            <!-- Heading -->
            <div class="sidebar-heading">
                Transaksi Penitipan
            </div>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'penitipan-uang') echo 'active'; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Penitipan Uang</span>
                </a>
                <div id="collapseTwo"
                    class="collapse <?php if ($this->uri->segment(1) == 'penitipan-uang') echo 'show'; ?>"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Penitipan Uang</h6>
                        <a class="collapse-item" href="<?= site_url('penitipan-uang/index') ?>">Input Baru</a>
                        <a class="collapse-item" href="<?= site_url('penitipan-uang/data') ?>">Data Penitipan</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'penitipanemas') echo 'active'; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#penitipanemas"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Penitipan Emas</span>
                </a>
                <div id="penitipanemas"
                    class="collapse <?php if ($this->uri->segment(1) == 'penitipanemas') echo 'show'; ?>"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Penitipan Emas</h6>
                        <a class="collapse-item" href="<?= site_url('penitipanemas/index') ?>">Input Baru</a>
                        <a class="collapse-item" href="<?= site_url('penitipanemas/data') ?>">Data Penitipan</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Transaksi Peminjaman
            </div>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'peminjamanuang') echo 'active'; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeminjamanuang"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-money-check"></i>
                    <span>Peminjaman Uang</span>
                </a>
                <div id="collapsePeminjamanuang"
                    class="collapse <?php if ($this->uri->segment(1) == 'peminjamanuang') echo 'show'; ?>"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Peminjaman Uang</h6>
                        <a class="collapse-item" href="<?= site_url('peminjamanuang/index') ?>">Input Baru</a>
                        <a class="collapse-item" href="<?= site_url('peminjamanuang/data') ?>">Data Peminjaman</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'peminjamanemas') echo 'active'; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePeminjamanemas"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-money"></i>
                    <span>Peminjaman Emas</span>
                </a>
                <div id="collapsePeminjamanemas"
                    class="collapse <?php if ($this->uri->segment(1) == 'peminjamanemas') echo 'show'; ?>"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Peminjaman Emas</h6>
                        <a class="collapse-item" href="<?= site_url('peminjamanemas/index') ?>">Input Baru</a>
                        <a class="collapse-item" href="<?= site_url('peminjamanemas/data') ?>">Data Peminjaman</a>
                    </div>
                </div>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Transaksi Pengeluaran
            </div>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'pengeluaran') echo 'active'; ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePengeluaran"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-ring"></i>
                    <span>Pengeluaran</span>
                </a>
                <div id="collapsePengeluaran"
                    class="collapse <?php if ($this->uri->segment(1) == 'pengeluaran') echo 'show'; ?>"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Pengeluaran</h6>
                        <a class="collapse-item" href="<?= site_url('pengeluaran/datajenis') ?>">Jenis Pengeluaran</a>
                        <a class="collapse-item" href="<?= site_url('pengeluaran/input') ?>">Input Pengeluaran</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider">
            <div class="sidebar-heading">
                Report
            </div>
            <li class="nav-item <?php if ($this->uri->segment(1) == 'report') echo 'active'; ?>">
                <a class="nav-link" href="<?= site_url('report/index') ?>">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Report</span></a>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('namauser') ?></span>
                                <img class="img-profile rounded-circle"
                                    src="<?= base_url('assets/img/blank-user.png') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">{judul}</h1>
                    {isi}
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Toko Mas H.Damrah Solok</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keluar Dari Aplikasi</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"> Yakin anda keluar dari aplikasi ini ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= site_url('login/keluar') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>