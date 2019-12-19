<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Pengeluaran extends CI_Controller
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

    function index()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripengeluaran', $cari);

            redirect('pengeluaran/index');
        } else {
            $cari = $this->session->userdata('caripengeluaran');
        }

        //Query data
        $q = "SELECT * FROM pengeluaran WHERE namapengeluaran LIKE '%$cari%' OR tglpengeluaran LIKE '%$cari%' ORDER BY tglpengeluaran DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('pengeluaran/index/');
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


        $qx = "SELECT * FROM pengeluaran WHERE namapengeluaran LIKE '%$cari%' OR tglpengeluaran LIKE '%$cari%' ORDER BY tglpengeluaran DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Data Pengeluaran',
            'isi' => $this->load->view('pengeluaran/vdata', $data, true)
        ];
        $this->parser->parse('layout/main', $view);
    }


    function tambah()
    {
        $view = [
            'judul' => 'Tambah Data Pengeluaran',
            'isi' => $this->load->view('pengeluaran/vformtambah', '', true)
        ];
        $this->parser->parse('layout/main', $view);
    }

    function simpandata()
    {
        $nama = $this->input->post('namapengeluaran');
        $tgl = $this->input->post('tgl');
        $jml = $this->input->post('jml');

        $datasimpan = [
            'namapengeluaran' => $nama, 'tglpengeluaran' => $tgl, 'jmlpengeluaran' => $jml
        ];
        $simpan = $this->db->insert('pengeluaran', $datasimpan);
        if ($simpan) {
            $pesan = ['pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Berhasil ! </span>
                Data Pengeluaran berhasil disimpan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>'];

            $this->session->set_flashdata($pesan);
            redirect('pengeluaran/index', 'refresh');
        }
    }

    function hapusdata()
    {
        $id = $this->uri->segment(3);

        $cek = $this->db->get_where('pengeluaran', ['id' => $id]);
        if ($cek->num_rows() > 0) {
            $this->db->delete('pengeluaran', ['id' => $id]);
            $pesan = ['pesan' => '<div class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                <span class="badge badge-pill badge-info">Berhasil ! </span>
                Data Pengeluaran berhasil di Hapus.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>'];

            $this->session->set_flashdata($pesan);
            redirect('pengeluaran/index', 'refresh');
        } else {
            exit('data tidak ditemukan');
        }
    }
}
