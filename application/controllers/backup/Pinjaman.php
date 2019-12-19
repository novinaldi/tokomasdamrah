<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pinjaman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true) {
            $this->load->library(['pagination', 'form_validation']);
            return true;
        } else {

            redirect('login/keluar', 'refresh');
        }
    }

    function buatnomor()
    {
        $tanggal = $this->input->post('tgl', true);


        $query = $this->db->query("SELECT MAX(pinjamanno) AS pinjamanno FROM pinjaman WHERE pinjamantgl='$tanggal'");
        $hasil = $query->row_array();
        $data  = $hasil['pinjamanno'];


        $lastNoUrut = substr($data, 9, 4);

        // nomor urut ditambah 1
        $nextNoUrut = $lastNoUrut + 1;

        // membuat format nomor transaksi berikutnya
        $nextNoTransaksi = 'PJ-' . date('dmy', strtotime($tanggal)) . sprintf('%04s', $nextNoUrut);
        echo $nextNoTransaksi;
    }

    function input()
    {
        $view = [
            'judul' => 'Tambah Data Pinjaman Pelanggan',
            'isi' => $this->load->view('pinjaman/vforminput', '', true)
        ];
        $this->parser->parse('layout/main', $view);
    }

    function caripelanggan()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('capel', $cari);

            redirect('pinjaman/caripelanggan');
        } else {
            $cari = $this->session->userdata('capel');
        }

        //Query data
        $q = "SELECT pelnik,pelnama,peljk,pelalamat FROM pelanggan WHERE pelnik LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pelnama ASC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('pinjaman/caripelanggan/');
        $config['total_rows'] = $total_data;
        $config['per_page'] = '10';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['uri_segment'] = 3;

        //Custom Pagination
        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        //custom pagination

        $this->pagination->initialize($config);
        //End

        $uri = $this->uri->segment(3);
        $per_page = $config['per_page'];

        if ($uri == null) {
            $start = 0;
        } else {
            $start = $uri;
        }
        //Query data perpage


        $qx = "SELECT pelnik,pelnama,peljk,pelalamat FROM pelanggan WHERE pelnik LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pelnama ASC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $total_data,
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $this->load->view('pinjaman/vcaridatapelanggan', $data);
    }

    function simpandata()
    {
        $nopinjaman = $this->input->post('nopinjaman');
        $tgl = $this->input->post('tglpinjam');
        $nikpelanggan = $this->input->post('nikpelanggan');
        $namapelanggan = $this->input->post('namapelanggan');
        $jmlpinjaman = $this->input->post('jmlpinjam');


        $this->form_validation->set_rules('nopinjaman', 'No.Pinjaman', 'trim|required', array(
            'required' => '%s tidak boleh kosong'
        ));
        $this->form_validation->set_rules('tglpinjam', 'Tgl.Pinjaman', 'trim|required', array(
            'required' => '%s tidak boleh kosong'
        ));
        $this->form_validation->set_rules('nikpelanggan', 'NIK Pelanggan', 'trim|required', array(
            'required' => '%s tidak boleh kosong'
        ));
        $this->form_validation->set_rules('jmlpinjam', 'Jumlah Pinjaman', 'trim|required|numeric', array(
            'required' => '%s tidak boleh kosong',
            'numeric' => 'inputan %s harus dalam bentuk angka'
        ));


        if ($this->form_validation->run() == true) {
            $datasimpan = [
                'pinjamanno' => $nopinjaman,
                'pinjamantgl' => $tgl,
                'pinjamanpelnik' => $nikpelanggan,
                'pinjamanjml' => $jmlpinjaman
            ];
            $simpandata = $this->db->insert('pinjaman', $datasimpan);
            if ($simpandata) {
                $pesan = [
                    'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success"><i class="fa fa-check"></i> Berhasil </span>
                   Data Pinjaman Pelanggan Berhasil tersimpan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>'

                ];
                $this->session->set_flashdata($pesan);
                redirect('pinjaman/input', 'refresh');
            }
        } else {
            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger"><i class="fa fa-ban"></i> Error</span>
                ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>'

            ];
            $this->session->set_flashdata($pesan);
            redirect('pinjaman/input', 'refresh');
        }
    }

    function data()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripinjaman', $cari);

            redirect('pinjaman/data');
        } else {
            $cari = $this->session->userdata('caripinjaman');
        }

        //Query data
        $q = "SELECT pinjamanno,pinjamantgl,pinjamanpelnik,pelnama,pinjamanjml,pinjamanstt FROM pinjaman JOIN pelanggan ON pinjamanpelnik=pelnik WHERE pinjamanno LIKE '%$cari%'OR pinjamantgl LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pinjamantgl DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('pinjaman/data/');
        $config['total_rows'] = $total_data;
        $config['per_page'] = '10';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['first_link'] = 'Awal';
        $config['last_link'] = 'Akhir';
        $config['uri_segment'] = 3;

        //Custom Pagination
        // Membuat Style pagination untuk BootStrap v4
        $config['first_link']       = 'First';
        $config['last_link']        = 'Last';
        $config['next_link']        = 'Next';
        $config['prev_link']        = 'Prev';
        $config['full_tag_open']    = '<div class="pagging text-center"><nav><ul class="pagination justify-content-center">';
        $config['full_tag_close']   = '</ul></nav></div>';
        $config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
        $config['num_tag_close']    = '</span></li>';
        $config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
        $config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
        $config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['prev_tagl_close']  = '</span>Next</li>';
        $config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
        $config['first_tagl_close'] = '</span></li>';
        $config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
        $config['last_tagl_close']  = '</span></li>';
        //custom pagination

        $this->pagination->initialize($config);
        //End

        $uri = $this->uri->segment(3);
        $per_page = $config['per_page'];

        if ($uri == null) {
            $start = 0;
        } else {
            $start = $uri;
        }
        //Query data perpage


        $qx = "SELECT pinjamanno,pinjamantgl,pinjamanpelnik,pelnama,pinjamanjml,pinjamanstt FROM pinjaman JOIN pelanggan ON pinjamanpelnik=pelnik WHERE pinjamanno LIKE '%$cari%'OR pinjamantgl LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pinjamantgl DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage
        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Data Pinjaman Pelanggan',
            'isi' => $this->load->view('pinjaman/vtampildata', $data, true)
        ];
        $this->parser->parse('layout/main', $view);
    }

    function edit()
    {
        $nopinjaman = $this->uri->segment(3);

        //cek data dulu
        $cektabelpinjaman = $this->db->get_where('pinjaman', ['pinjamanno' => $nopinjaman]);
        if ($cektabelpinjaman->num_rows() > 0) {
            $r = $cektabelpinjaman->row_array();

            //ambil data pelanggan
            $cekdatapelanggan = $this->db->get_where('pelanggan', ['pelnik' => $r['pinjamanpelnik']]);
            $rpelanggan = $cekdatapelanggan->row_array();
            $data = [
                'tglpinjaman' => $r['pinjamantgl'],
                'nopinjaman' => $nopinjaman,
                'jmlpinjaman' => $r['pinjamanjml'],
                'nikpelanggan' => $r['pinjamanpelnik'],
                'namapelanggan' => $rpelanggan['pelnama']
            ];
            $view = [
                'judul' => 'Edit Data Pinjaman Pelanggan',
                'isi' => $this->load->view('pinjaman/vformedit', $data, true)
            ];
            $this->parser->parse('layout/main', $view);
        } else {
            exit('maaf data ini tidak ditemukan');
        }
    }

    function updatedata()
    {
        $nopinjaman = $this->input->post('nopinjaman');
        $jmlpinjaman = $this->input->post('jmlpinjam');

        $dataupdate = [
            'pinjamanjml' => $jmlpinjaman
        ];
        $this->db->where('pinjamanno', $nopinjaman);
        $this->db->update('pinjaman', $dataupdate);

        $pesan = [
            'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-success"><i class="fa fa-check"></i> Berhasil </span>
           <strong>Data Pinjaman Pelanggan Berhasil di Update</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>'

        ];
        $this->session->set_flashdata($pesan);
        redirect('pinjaman/data', 'refresh');
    }

    function pembayaran()
    {
        $nopinjaman = $this->uri->segment(3);

        //cek data dulu
        $cektabelpinjaman = $this->db->get_where('pinjaman', ['pinjamanno' => $nopinjaman]);
        if ($cektabelpinjaman->num_rows() > 0) {
            $r = $cektabelpinjaman->row_array();

            //ambil data pelanggan
            $cekdatapelanggan = $this->db->get_where('pelanggan', ['pelnik' => $r['pinjamanpelnik']]);
            $rpelanggan = $cekdatapelanggan->row_array();
            $data = [
                'tglpinjaman' => date('d-m-Y', strtotime($r['pinjamantgl'])),
                'nopinjaman' => $nopinjaman,
                'jmlpinjaman' => number_format($r['pinjamanjml'], 0),
                'nikpelanggan' => $r['pinjamanpelnik'],
                'namapelanggan' => $rpelanggan['pelnama'],
                'status'  => $r['pinjamanstt'],
                'sisa' => number_format($r['pinjamansisa'], 0)
            ];
            $view = [
                'judul' => 'Detail Pembayaran Pinjaman',
                'isi' => $this->load->view('pinjaman/vdetailpembayaran', $data, true)
            ];
            $this->parser->parse('layout/main', $view);
        } else {
            exit('maaf data ini tidak ditemukan');
        }
    }

    function formtambahpembayaran()
    {
        $nopinjaman = $this->input->post('nopinjaman');
        $data = ['nopinjaman' => $nopinjaman];

        $this->load->view('pinjaman/viewformtambahpembayaran', $data);
        // $cektabelpinjaman = $this->db->get_where('pinjaman', ['pinjamanno' => $nopinjaman]);
    }

    function simpanpembayaran()
    {
        $nopinjaman = $this->input->post('nopinjaman');
        $tglbayar = $this->input->post('tglbayar');
        $jmlbayar = $this->input->post('jmlbayar');
        $carabayar = $this->input->post('carabayar');

        $uploadbukti = $_FILES["uploadbukti"]["name"];

        $cektabelpinjaman = $this->db->get_where('pinjaman', ['pinjamanno' => $nopinjaman]);
        $r = $cektabelpinjaman->row_array();
        $jmlpinjaman = $r['pinjamanjml'];
        $pinjamansisa = $r['pinjamansisa'];

        if ($pinjamansisa == 0) {
            $sisapinjaman = $jmlpinjaman - $jmlbayar;
        } else {
            $sisapinjaman = $pinjamansisa - $jmlbayar;
        }

        if ($carabayar == 1) {
            $datasimpan = [
                'bayartgl' => $tglbayar,
                'bayarpinjamanno' => $nopinjaman,
                'bayarjml' => $jmlbayar,
                'bayarcara' => $carabayar
            ];

            $this->db->insert('bayarpinjaman', $datasimpan);

            //Update jml pinjaman pada tabel pinjaman
            if ($sisapinjaman == 0) {
                $dataupdatepinjaman = [
                    'pinjamansisa' => $sisapinjaman,
                    'pinjamanstt' => 1
                ];
            } else {
                $dataupdatepinjaman = [
                    'pinjamansisa' => $sisapinjaman
                ];
            }
            $this->db->where('pinjamanno', $nopinjaman);
            $this->db->update('pinjaman', $dataupdatepinjaman);

            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Berhasil !</span>
                <strong>Pembayaran berhasil ditambahkan</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('pinjaman/pembayaran/' . $nopinjaman, 'refresh');
        } else {
            $config = array(
                'upload_path' => './temp/upload/buktitransfer/', //nama folder di root
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'file_name' => strtolower(date('dmY', strtotime($tglbayar)) . $nopinjaman)
            );
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadbukti')) {
                $pesan = [
                    'pesan' => '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                    <span class="badge badge-pill badge-danger">Error !</span>
                    ' . $this->upload->display_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('pinjaman/pembayaran/' . $nopinjaman, 'refresh');
            } else {
                $media = $this->upload->data();
                $pathfotobaru = './temp/upload/buktitransfer/' . $media['file_name'];
                $datasimpan = [
                    'bayartgl' => $tglbayar,
                    'bayarpinjamanno' => $nopinjaman,
                    'bayarjml' => $jmlbayar,
                    'bayarcara' => $carabayar,
                    'bayarfoto' => $pathfotobaru
                ];

                $this->db->insert('bayarpinjaman', $datasimpan);

                //Update jml pinjaman pada tabel pinjaman
                if ($sisapinjaman == 0) {
                    $dataupdatepinjaman = [
                        'pinjamansisa' => $sisapinjaman,
                        'pinjamanstt' => 1
                    ];
                } else {
                    $dataupdatepinjaman = [
                        'pinjamansisa' => $sisapinjaman
                    ];
                }
                $this->db->where('pinjamanno', $nopinjaman);
                $this->db->update('pinjaman', $dataupdatepinjaman);

                $pesan = [
                    'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Berhasil !</span>
                    <strong>Pembayaran berhasil ditambahkan</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('pinjaman/pembayaran/' . $nopinjaman, 'refresh');
            }
        }
    }

    function hapusdata()
    {
        $nopinjaman = $this->uri->segment(3);

        //cek di tabel pembayaran 
        $cekdatapembayaran = $this->db->get_where('bayarpinjaman', ['bayarpinjamanno' => $nopinjaman]);
        if ($cekdatapembayaran->num_rows() > 0) {
            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error !</span>
                <strong>Maaf anda tidak bisa menghapus data ini, dikarenakan ada detail pembayaran. Silahkan hapus terlebih dahulu</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('pinjaman/data', 'refresh');
        } else {
            //hapus pinjaman pelanggan
            $this->db->delete('pinjaman', ['pinjamanno' => $nopinjaman]);
            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Berhasil ! </span>
                <strong>Data dengan No.Pinjaman  : ' . $nopinjaman . ' berhasil dihapus </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('pinjaman/data', 'refresh');
        }
    }

    function hapusbayar()
    {
        $idbayar = $this->uri->segment(3);
        $nopinjaman = $this->uri->segment(4);

        $ambildatapembayaran = $this->db->get_where('bayarpinjaman', ['bayarid' => $idbayar]);
        $r = $ambildatapembayaran->row_array();
        $pathfotobukti = $r['bayarfoto'];
        $jmlbayar = $r['bayarjml'];

        @unlink($pathfotobukti);

        $cektabelpinjaman = $this->db->get_where('pinjaman', ['pinjamanno' => $nopinjaman]);
        $r = $cektabelpinjaman->row_array();
        $pinjamansisa = $r['pinjamansisa'];

        $dataupdatepinjaman = [
            'pinjamansisa' => $pinjamansisa + $jmlbayar
        ];
        $this->db->where('pinjamanno', $nopinjaman);
        $this->db->update('pinjaman', $dataupdatepinjaman);

        $this->db->delete('bayarpinjaman', ['bayarid' => $idbayar]);
        $pesan = [
            'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            <span class="badge badge-pill badge-danger">Terhapus !</span>
            <strong>Detail Pembayaran berhasil dihapus</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
        </div>'
        ];
        $this->session->set_flashdata($pesan);
        redirect('pinjaman/pembayaran/' . $nopinjaman, 'refresh');
    }
}
