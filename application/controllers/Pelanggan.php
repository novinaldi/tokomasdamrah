<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pelanggan extends CI_Controller
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

    function tambah()
    {
        $view = [
            'judul' => 'Tambah Data Pelanggan',
            'isi' => $this->load->view('pelanggan/vformtambah', '', true)
        ];
        $this->parser->parse('template/index', $view);
    }

    function simpandata()
    {
        $nik = $this->input->post('nik', true);
        $nama = $this->input->post('nama', true);
        $jk = $this->input->post('jk', true);
        $nohp = $this->input->post('nohp', true);
        $alamat = $this->input->post('alamat', true);


        $this->form_validation->set_rules(
            'nohp',
            'No.Handphone atau Telp',
            'trim|required|is_unique[pelanggan.pelnohp]',
            array(
                'required' => '%s tidak boleh kosong',
                'is_unique' => '%s tidak boleh ada yang sama atau sudah ada yang memiliki'
            )
        );
        $this->form_validation->set_rules(
            'nik',
            'NIK',
            'trim|required|min_length[16]|max_length[16]|is_unique[pelanggan.pelnik]',
            array(
                'required' => '%s tidak boleh kosong',
                'min_length' => 'Minimal Inputan %s sebanyak 16 digit',
                'max_length' => 'Maksimal Inputan %s sebanyak 16 digit',
                'is_unique' => '%s tidak boleh ada yang sama atau sudah ada yang memiliki'
            )
        );
        $this->form_validation->set_rules(
            'nama',
            'Nama Pelanggan',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'jk',
            'Jenis Kelamin',
            'trim|required',
            array(
                'required' => '%s harus dipilih'
            )
        );
        $this->form_validation->set_rules(
            'alamat',
            'Alamat',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong, isikan tanda (-) jika harus kosong'
            )
        );

        if ($this->form_validation->run() == true) {
            $datasimpan = [
                'pelnik' => $nik, 'pelnama' => $nama, 'peljk' => $jk, 'pelalamat' => $alamat,
                'pelnohp' => $nohp
            ];
            $this->db->insert('pelanggan', $datasimpan);

            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Berhasil</span>
                Data berhasil Tersimpan
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>'
            ];

            $this->session->set_flashdata($pesan);
            redirect('pelanggan/index', 'refresh');
        } else {
            $session = [
                'nik' => $nik, 'nama' => $nama,
                'alamat' => $alamat
            ];
            $this->session->set_flashdata($session);

            $this->tambah();
        }
    }
    function index()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('capel', $cari);

            redirect('pelanggan/index');
        } else {
            $cari = $this->session->userdata('capel');
        }

        //Query data
        $q = "SELECT pelnik,pelnama,peljk,pelalamat,pelnohp FROM pelanggan WHERE pelnik LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pelnama ASC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('pelanggan/index/');
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


        $qx = "SELECT pelnik,pelnama,peljk,pelalamat,pelnohp FROM pelanggan WHERE pelnik LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY pelnama ASC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Data Pelanggan',
            'isi' => $this->load->view('pelanggan/vdata', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }

    public function hapusdata()
    {
        $nik = $this->uri->segment(3);
        $cekData = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
        if ($cekData->num_rows() > 0) {
            $hapusdata = $this->db->delete('pelanggan', ['pelnik' => $nik]);
            if ($hapusdata) {
                $pesan = ['pesan' => '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Hapus Data</span>
                Data pelanggan berhasil terhapus.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>'];

                $this->session->set_flashdata($pesan);
            }
            redirect('pelanggan/index', 'refresh');
        } else  exit('Maaf data tidak ditemukan');
    }

    public function detail()
    {
        $nik = $this->uri->segment(3);
        $cekData = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
        if ($cekData->num_rows() > 0) {
            $r = $cekData->row_array();
            $data = [
                'nik' => $r['pelnik'],
                'nama' => $r['pelnama'],
                'jk' => $r['peljk'],
                'alamat' => $r['pelalamat'],
                'nohp' => $r['pelnohp'],
                'foto' => $r['pelfoto']
            ];
            $view = [
                'judul' => 'Detail Pelanggan',
                'isi' => $this->load->view('pelanggan/vdetail', $data, true)
            ];
            $this->parser->parse('template/index', $view);
        } else  exit('Maaf data tidak ditemukan');
    }

    public function edit()
    {
        $nik = $this->uri->segment(3);
        $cekData = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
        if ($cekData->num_rows() > 0) {
            $r = $cekData->row_array();
            $data = [
                'nik' => $r['pelnik'],
                'nama' => $r['pelnama'],
                'jk' => $r['peljk'],
                'nohp' => $r['pelnohp'],
                'alamat' => $r['pelalamat']
            ];
            $view = [
                'judul' => 'Update Pelanggan',
                'isi' => $this->load->view('pelanggan/vformedit', $data, true)
            ];
            $this->parser->parse('template/index', $view);
        } else  exit('Maaf data tidak ditemukan');
    }

    public function updatedata()
    {
        $nik = $this->input->post('nik', true);
        $nama = $this->input->post('nama', true);
        $jk = $this->input->post('jk', true);
        $nohp = $this->input->post('nohp', true);
        $alamat = $this->input->post('alamat', true);

        $this->form_validation->set_rules(
            'nohp',
            'No.Handphone atau Telp',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'nama',
            'Nama Pelanggan',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );
        $this->form_validation->set_rules(
            'jk',
            'Jenis Kelamin',
            'trim|required',
            array(
                'required' => '%s harus dipilih'
            )
        );


        if ($this->form_validation->run() == true) {
            $datasimpan = [
                'pelnama' => $nama, 'peljk' => $jk, 'pelalamat' => $alamat,
                'pelnohp' => $nohp
            ];
            $this->db->where('pelnik', $nik);
            $this->db->update('pelanggan', $datasimpan);

            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Berhasil</span>
                Data berhasil Ter-Update
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>'
            ];

            $this->session->set_flashdata($pesan);
            redirect('pelanggan/detail/' . $nik, 'refresh');
        } else {
            redirect('pelanggan/edit/' . $nik, 'refresh');
        }
    }

    public function formupload()
    {
        $nik = $this->uri->segment(3);
        $cekData = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
        if ($cekData->num_rows() > 0) {
            $r = $cekData->row_array();
            $data = [
                'nik' => $r['pelnik']
            ];
            $view = [
                'judul' => 'Upload Foto KTP Pelanggan',
                'isi' => $this->load->view('pelanggan/vformupload', $data, true)
            ];
            $this->parser->parse('template/index', $view);
        } else  exit('Maaf data tidak ditemukan');
    }

    function doupload()
    {
        $nik = $this->input->post('nik', true);


        $ambildata = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
        $r = $ambildata->row_array();
        $pathfotolama = $r['pelfoto'];
        if ($_FILES['uploadktp']['name'] == NULL) {
            //upload dari webcam

            $image = $_POST['imagecam'];
            $image = str_replace('data:image/jpeg;base64,', '', $image);

            $image = base64_decode($image, true);
            // echo $image;
            $filename = $nik . '_' . time() . '.jpg';
            file_put_contents(FCPATH . '/assets/upload/ktppelanggan/' . $filename, $image);

            @unlink($pathfotolama);

            //update foto pelanggan
            $dataupdate = [
                'pelfoto' => './assets/upload/ktppelanggan/' . $filename
            ];
            $this->db->where('pelnik', $nik);
            $this->db->update('pelanggan', $dataupdate);

            $pesan = [
                'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                <span class="badge badge-pill badge-success">Upload Foto Berhasil !</span>
                Silahkan tekan tombol kembali untuk melihat foto yang telah di upload...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
            </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('pelanggan/formupload/' . $nik, 'refresh');
        } else {
            $config = array(
                'upload_path' => './assets/upload/ktppelanggan/', //nama folder di root
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'file_name' => strtolower($nik) . '_' . time()
            );
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadktp')) {

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
                redirect('pelanggan/formupload/' . $nik, 'refresh');
            } else {
                @unlink($pathfotolama);

                $media = $this->upload->data();
                $pathfotobaru = './assets/upload/ktppelanggan/' . $media['file_name'];

                //update foto pelanggan
                $dataupdate = [
                    'pelfoto' => $pathfotobaru
                ];
                $this->db->where('pelnik', $nik);
                $this->db->update('pelanggan', $dataupdate);

                $pesan = [
                    'pesan' => '<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
                    <span class="badge badge-pill badge-success">Upload Foto Berhasil !</span>
                    Silahkan tekan tombol kembali untuk melihat foto yang telah di upload...
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('pelanggan/formupload/' . $nik, 'refresh');
            }
        }
    }
}