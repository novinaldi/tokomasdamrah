<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Penitipan extends CI_Controller
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


        $query = $this->db->query("SELECT MAX(penitipanid) AS penitipanid FROM penitipan WHERE penitipantgl='$tanggal'");
        $hasil = $query->row_array();
        $data  = $hasil['penitipanid'];


        $lastNoUrut = substr($data, 9, 4);

        // nomor urut ditambah 1
        $nextNoUrut = $lastNoUrut + 1;

        // membuat format nomor transaksi berikutnya
        $nextNoTransaksi = 'PN-' . date('dmy', strtotime($tanggal)) . sprintf('%04s', $nextNoUrut);
        echo $nextNoTransaksi;
    }

    function input()
    {
        //Buat Nomor Penitipan 

        $view = [
            'judul' => 'Tambah Data Penitipan Pelanggan',
            'isi' => $this->load->view('penitipan/vforminput', '', true)
        ];
        $this->parser->parse('layout/main', $view);
    }

    function caripelanggan()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('capel', $cari);

            redirect('penitipan/caripelanggan');
        } else {
            $cari = $this->session->userdata('capel');
        }

        //Query data
        $q = "SELECT pelnik,pelnama,peljk,pelalamat FROM pelanggan WHERE pelnik LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pelnama ASC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('penitipan/caripelanggan/');
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
        $this->load->view('penitipan/vcaridatapelanggan', $data);
    }

    public function simpandata()
    {
        $tgltitip = $this->input->post('tgltitip', true);
        $nopenitipan = $this->input->post('nopenitipan', true);
        $nikpelanggan = $this->input->post('nikpelanggan', true);

        $this->form_validation->set_rules(
            'tgltitip',
            'Tanggal Penitipan',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'nopenitipan',
            'No.Penitipan',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'nikpelanggan',
            'NIK Pelanggan',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'namapelanggan',
            'Nama Pelanggan',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );


        if ($this->form_validation->run() == true) {
            //Lakukan simpan data
            $datapenitipan = [
                'penitipanid' => $nopenitipan,
                'penitipantgl' => $tgltitip,
                'penitipanpelnik' => $nikpelanggan,
                'penitipanstt' => 0,
                'penitipantotal' => 0
            ];
            $simpandatapenitipan = $this->db->insert('penitipan', $datapenitipan);
            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success"><i class="fa fa-checked"></i> Berhasil </span>&nbsp; Data penitipan berhasil tersimpan, untuk menambahkan Detail Penitipan, Silahkan klik menu Detail pada bagian kiri.  
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>',
                'nopenitipan' => $nopenitipan,
                'tglpenitipan' => $tgltitip,

            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipan/input', 'refresh');
        } else {
            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger"><i class="fa fa-ban"></i> Error</span>
                ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>',
                'nopenitipan' => $nopenitipan,
                'tglpenitipan' => $tgltitip,

            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipan/input', 'refresh');
        }
    }

    public function data()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripenitipan', $cari);

            redirect('penitipan/data');
        } else {
            $cari = $this->session->userdata('caripenitipan');
        }

        //Query data
        $q = "SELECT penitipanid,DATE_FORMAT(penitipantgl,'%d-%m-%Y') AS tgl,CONCAT(penitipanpelnik,'/',pelnama) AS pelanggan,
        penitipantotal AS total, penitipanstt FROM penitipan JOIN pelanggan ON pelnik=penitipanpelnik WHERE penitipanid LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY penitipanid DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('penitipan/data/');
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


        $qx = "SELECT penitipanid,DATE_FORMAT(penitipantgl,'%d-%m-%Y') AS tgl,CONCAT(penitipanpelnik,'/',pelnama) AS pelanggan,
        penitipantotal AS total, penitipanstt FROM penitipan JOIN pelanggan ON pelnik=penitipanpelnik WHERE penitipanid LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY penitipanid DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage
        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Data Penitipan',
            'isi' => $this->load->view('penitipan/vtampildata', $data, true)
        ];
        $this->parser->parse('layout/main', $view);
    }

    public function hapussemuadata()
    {
        $id = $this->uri->segment(3);
        $cekdatadulu = $this->db->get_where('penitipan', ['penitipanid' => $id]);
        if ($cekdatadulu->num_rows() > 0) {
            //hapus detail penitipan
            $hapusdetail = $this->db->delete('detailpenitipan', ['dettitipno' => $id]);
            $hapuspenitipan = $this->db->delete('penitipan', ['penitipanid' => $id]);
            if ($hapuspenitipan) {
                $pesan = ['pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Hapus Data</span>
                Semua Data Penitipan berhasil terhapus.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>'];

                $this->session->set_flashdata($pesan);

                redirect('penitipan/data', 'refresh');
            }
        } else {
            exit('Maaf data tidak ditemukan');
        }
    }

    public function detail()
    {
        $id = $this->uri->segment(3);
        $cekdatadulu = $this->db->get_where('penitipan', ['penitipanid' => $id]);
        if ($cekdatadulu->num_rows() > 0) {
            $r = $cekdatadulu->row_array();
            $datapelanggan = $this->db->get_where('pelanggan', ['pelnik' => $r['penitipanpelnik']]);
            $rpelanggan = $datapelanggan->row_array();
            $data = [
                'id' => $id,
                'nik' => $r['penitipanpelnik'],
                'namapelanggan' => $rpelanggan['pelnama'],
                'tanggal' => date('d-m-Y', strtotime($r['penitipantgl'])),
                'totalpenitipan' => number_format($r['penitipantotal']),
                'status' => $r['penitipanstt']
            ];
            $view = [
                'judul' => 'Detail Data Penitipan',
                'isi' => $this->load->view('penitipan/vdetailpenitipan', $data, true)
            ];
            $this->parser->parse('layout/main', $view);
        } else {
            exit('Maaf data tidak ditemukan');
        }
    }

    function formtambahdatadetail()
    {
        $idpenitipan = $this->input->post('idpenitipan', true);
        $data = [
            'idpenitipan' => $idpenitipan
        ];
        $this->load->view('penitipan/vformtambahdetailpenitipan', $data);
    }

    function simpandetailpenitipan()
    {
        $idpenitipan = $this->input->post('idpenitipan', true);
        $tgl = $this->input->post('tgldetailpenitipan', true);
        $jml = $this->input->post('jml', true);

        $ambildatapenitipan = $this->db->get_where('penitipan', ['penitipanid' => $idpenitipan]);
        $r = $ambildatapenitipan->row_array();
        $totalpenitipan = $r['penitipantotal'];

        $datasimpan = [
            'dettitipno' => $idpenitipan,
            'dettitiptgl' => $tgl,
            'dettitipjml' => $jml
        ];
        $simpan = $this->db->insert('detailpenitipan', $datasimpan);

        if ($simpan) {
            //update total tabel penitipan
            $datapenitipan = [
                'penitipantotal' => $totalpenitipan + $jml
            ];
            $this->db->where('penitipanid', $idpenitipan);
            $this->db->update('penitipan', $datapenitipan);
            $pesan = ['pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Berhasil !!!</span> &nbsp;
                Data berhasil ditambahkan.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>'];

            $this->session->set_flashdata($pesan);

            redirect('penitipan/detail/' . $idpenitipan, 'refresh');
        }
    }

    function hapusdetailpenitipan()
    {
        $iddetail = $this->uri->segment(3);
        $idpenitipan = $this->uri->segment(4);

        $ambildatapenitipan = $this->db->get_where('penitipan', ['penitipanid' => $idpenitipan]);
        $r = $ambildatapenitipan->row_array();
        $totalpenitipan = $r['penitipantotal'];

        $ambildatadetailpenitipan = $this->db->get_where('detailpenitipan', ['dettitipid' => $iddetail]);
        $x = $ambildatadetailpenitipan->row_array();
        $jml = $x['dettitipjml'];

        //update total tabel penitipan
        $datapenitipan = [
            'penitipantotal' => $totalpenitipan - $jml
        ];
        $this->db->where('penitipanid', $idpenitipan);
        $this->db->update('penitipan', $datapenitipan);

        //hapus detail
        $hapus = $this->db->delete('detailpenitipan', ['dettitipid' => $iddetail]);
        if ($hapus) {
            $pesan = ['pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-danger">Hapus data detail !!!</span> &nbsp;
                    Data berhasil di-hapus.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>'];

            $this->session->set_flashdata($pesan);

            redirect('penitipan/detail/' . $idpenitipan, 'refresh');
        }
    }

    function konfirmasipengambilan()
    {
        $id = $this->uri->segment(3);
        $cekdatadulu = $this->db->get_where('penitipan', ['penitipanid' => $id]);
        if ($cekdatadulu->num_rows() > 0) {
            $r = $cekdatadulu->row_array();

            $datapelanggan = $this->db->get_where('pelanggan', ['pelnik' => $r['penitipanpelnik']]);
            $rpelanggan = $datapelanggan->row_array();
            $data = [
                'idpenitipan' => $id,
                'tglpenitipan' => date('d-m-Y', strtotime($r['penitipantgl'])),
                'pelanggan' => $r['penitipanpelnik'] . ' / ' . $rpelanggan['pelnama'],
                'totalpenitipan' => number_format($r['penitipantotal'], 0) . '&nbsp;&nbsp;Gram',
                'status' => $r['penitipanstt'],
                'tglpengambilan' => date('d-m-Y', strtotime($r['penitipantglambil']))
            ];

            $view = [
                'judul' => 'Konfirmasi Pengambilan',
                'isi' => $this->load->view('penitipan/vformpengambilantitipan', $data, true)
            ];
            $this->parser->parse('layout/main', $view);
        } else {
            exit('Maaf data tidak ditemukan');
        }
    }

    function simpanpengambilan()
    {
        $idpenitipan = $this->input->post('idpenitipan', true);
        $tgl = $this->input->post('tglambil', true);

        $dataupdatepenitipan = [
            'penitipanstt' => 1,
            'penitipantglambil' => $tgl
        ];

        $this->db->where('penitipanid', $idpenitipan);
        $update =  $this->db->update('penitipan', $dataupdatepenitipan);

        if ($update) {
            $pesan =
                [
                    'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                                <span class="badge badge-pill badge-success">Penitipan di Ambil</span> &nbsp;
                                Penitipan Pelanggan sudah di ambil pada tanggal ' . $tgl . '
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>'
                ];

            $this->session->set_flashdata($pesan);

            redirect('penitipan/konfirmasipengambilan/' . $idpenitipan, 'refresh');
        }
    }

    function batalkankonfirmasipengambilan()
    {
        $idpenitipan = $this->uri->segment(3);

        $dataupdatepenitipan = [
            'penitipanstt' => 0,
            'penitipantglambil' => ''
        ];

        $this->db->where('penitipanid', $idpenitipan);
        $update =  $this->db->update('penitipan', $dataupdatepenitipan);

        if ($update) {
            $pesan =
                [
                    'pesan' => '<div class="sufee-alert alert with-close alert-info alert-dismissible fade show">
                                <span class="badge badge-pill badge-success">Penitipan di Ambil</span> &nbsp;
                                Berhasil di Batalkan Konfirmasinya
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>'
                ];
            $this->session->set_flashdata($pesan);

            redirect('penitipan/konfirmasipengambilan/' . $idpenitipan, 'refresh');
        }
    }
}
