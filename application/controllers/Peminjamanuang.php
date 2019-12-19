<?php
class Peminjamanuang extends CI_Controller
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
        $view = [
            'judul' => 'Input Peminjaman Uang Pelanggan',
            'isi' => $this->load->view('peminjamanuang/forminput', '', true)
        ];
        $this->parser->parse('template/index', $view);
    }

    function caripelanggan()
    {
        $this->load->view('peminjamanuang/vcaripelanggan');
    }
    function ambildetailpelanggan()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $nik = $this->input->post('nik', true);
            $ambildata = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
            $r = $ambildata->row_array();
            $data = [
                'namapelanggan' => $r['pelnama']
            ];
            echo json_encode($data);
        } else {
            exit('maaf data tidak bisa dieksekusi');
        }
    }
    function ambildatapelanggan()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $this->load->model('Modelpelanggan', 'pelanggan');
            $list = $this->pelanggan->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->pelnik;
                $row[] = $field->pelnama;
                $row[] = $field->pelalamat;
                $row[] = "<button type=button class='btn btn-outline-success' onclick='pilihdata(" . $field->pelnik . ")'>Pilih</button>";
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->pelanggan->count_all(),
                "recordsFiltered" => $this->pelanggan->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function simpandata()
    {
        $nopeminjaman = $this->input->post('nopeminjaman', true);
        $tglpeminjaman = $this->input->post('tglpeminjaman', true);
        $nikpel = $this->input->post('nikpel', true);
        $jmlpeminjaman = $this->input->post('jmlpeminjaman', true);
        $ket = $this->input->post('ket', true);

        $this->form_validation->set_rules('nopeminjaman', 'No.Peminjaman', 'trim|required|is_unique[pinjaman_uang.nomor]', array(
            'is_unique' => '%s yang diinputkan sudah ada didalam database, silahkan coba dengan nomor yang lain'
        ));
        if ($this->form_validation->run() == TRUE) {
            if ($_FILES['uploadbukti']['name'] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipeminjaman/', //nama folder di root
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 0,
                    'max_width' => 0,
                    'max_height' => 0,
                    'file_name' => strtolower(date('dmy', strtotime($tglpeminjaman)) . $nopeminjaman)
                );
                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('uploadbukti')) {
                    $pesan = [
                        'pesan' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error !</strong> ' . $this->upload->display_errors() . '
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'
                    ];
                    $this->session->set_flashdata($pesan);
                    redirect('peminjamanuang/index', 'refresh');
                } else {
                    $media = $this->upload->data();
                    $pathbukitbaru = './assets/upload/buktipeminjaman/' . $media['file_name'];

                    $datasimpan_peminjamanuang = [
                        'nomor' => $nopeminjaman, 'tglawal' => $tglpeminjaman,
                        'nikpel' => $nikpel, 'jmltotalpinjam' => $jmlpeminjaman
                    ];
                    $datasimpan_detailpeminjamanuang = [
                        'nodetail' => $nopeminjaman, 'tgl' => $tglpeminjaman,
                        'pilihan' => 1,
                        'jml' => $jmlpeminjaman, 'buktifoto' => $pathbukitbaru,
                        'ket' => $ket
                    ];
                }
            } else {
                $datasimpan_peminjamanuang = [
                    'nomor' => $nopeminjaman, 'tglawal' => $tglpeminjaman,
                    'nikpel' => $nikpel, 'jmltotalpinjam' => $jmlpeminjaman
                ];
                $datasimpan_detailpeminjamanuang = [
                    'nodetail' => $nopeminjaman, 'tgl' => $tglpeminjaman,
                    'pilihan' => 1,
                    'jml' => $jmlpeminjaman,
                    'ket' => $ket
                ];
            }
            //simpan data pinjaman uang
            $this->db->trans_start();
            $this->db->insert('pinjaman_uang', $datasimpan_peminjamanuang);
            $this->db->insert('detailpinjaman_uang', $datasimpan_detailpeminjamanuang);
            $this->db->trans_complete();

            if ($this->db->trans_status() == true) {
                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4>Berhasil !</h4> Data dengan No.Peminjaman : ' . $nopeminjaman . ' berhasil tersimpan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('peminjamanuang/index', 'refresh');
            }
        } else {
            $pesan = [
                'pesan' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('peminjamanuang/index', 'refresh');
        }
    }

    function data()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripeminjamanuang', $cari);

            redirect('peminjamanuang/data');
        } else {
            $cari = $this->session->userdata('caripeminjamanuang');
        }

        //Query data
        $q = "SELECT nomor,tglawal,nikpel,pelnama,jmltotalpinjam,jmltotalbayar FROM pinjaman_uang JOIN pelanggan ON pelnik=nikpel 
        WHERE nomor LIKE '%$cari%' OR nikpel LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY tglawal DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('peminjamanuang/data/');
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


        $qx = "SELECT nomor,tglawal,nikpel,pelnama,jmltotalpinjam,jmltotalbayar FROM pinjaman_uang JOIN pelanggan ON pelnik=nikpel 
        WHERE nomor LIKE '%$cari%' OR nikpel LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY tglawal DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Seluruh Data Peminjaman Uang Pelanggan',
            'isi' => $this->load->view('peminjamanuang/vseluruhdata', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }

    function hapusdata()
    {
        $nopeminjaman = $this->uri->segment(3);

        //cek data
        $cekdatapeminjaman = $this->db->get_where('pinjaman_uang', ['nomor' => $nopeminjaman]);
        if ($cekdatapeminjaman->num_rows() > 0) {

            $qdatadetail = $this->db->get_where('detailpinjaman_uang',['nodetail' => $nopeminjaman]);
            foreach($qdatadetail->result_array() as $rq){
                $pathdetail = $rq['buktifoto'];
                @unlink($pathdetail);
            }


            $this->db->trans_start();
            $this->db->delete('detailpinjaman_uang', ['nodetail' => $nopeminjaman]);
            $this->db->delete('pinjaman_uang', ['nomor' => $nopeminjaman]);
            $this->db->trans_complete();

            if ($this->db->trans_status() == true) {
                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4>Berhasil !</h4> Data dengan No.Peminjaman : ' . $nopeminjaman . ' berhasil di hapus
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('peminjamanuang/data', 'refresh');
            }
        } else {
            exit('Maaf data tidak ditemukan');
        }
    }

    function detaildata()
    {
        $nopeminjaman = $this->uri->segment(3);

        //cek data
        $cekdatapeminjaman = $this->db->get_where('pinjaman_uang', ['nomor' => $nopeminjaman]);
        if ($cekdatapeminjaman->num_rows() > 0) {
            $r = $cekdatapeminjaman->row_array();
            $nik = $r['nikpel'];

            //ambil data pelanggan
            $querydatapelanggan = $this->db->get_where('pelanggan', ['pelnik' => $nik]);
            $rpel = $querydatapelanggan->row_array();

            $data = [
                'nopeminjaman' => $nopeminjaman,
                'tgl' => date('d-m-Y', strtotime($r['tglawal'])),
                'nik' => $nik,
                'namapelanggan' => $rpel['pelnama'],
                'jmltotalpinjam' => $r['jmltotalpinjam'],
                'jmltotalbayar' => $r['jmltotalbayar']
            ];

            $view = [
                'judul' => 'Detail Data Peminjaman Uang Pelanggan',
                'isi' => $this->load->view('peminjamanuang/vdetaildata', $data, true)
            ];
            $this->parser->parse('template/index', $view);
        } else {
            exit('Maaf data tidak ditemukan');
        }
    }

    function formtambahpinjaman()
    {
        if ($this->input->is_ajax_request() == true) {
            $nopeminjaman = $this->input->post('nomor', true);
            $data = [
                'nopeminjaman' => $nopeminjaman
            ];
            $this->load->view('peminjamanuang/modalformtambah', $data);
        } else {
            redirect('peminjamanuang/data', 'refresh');
        }
    }

    function tampilkanbuktifoto()
    {
        $id = $this->input->post('id', true);
        $q = $this->db->get_where('detailpinjaman_uang', ['iddetail' => $id]);
        $r = $q->row_array();

        $data = [
            'buktifoto' => $r['buktifoto']
        ];
        $this->load->view('peminjamanuang/modallihatbuktifoto', $data);
    }

    function simpandetailpeminjaman()
    {
        $nopeminjaman = $this->input->post('nopeminjaman', true);
        $tgl = $this->input->post('tgl', true);
        $jml = $this->input->post('jml', true);
        $ket = $this->input->post('ket', true);

        //ambil data tabel pinjaman uang 
        $queryambildata_pinjaman = $this->db->get_where('pinjaman_uang', ['nomor' => $nopeminjaman]);
        $rpinjaman = $queryambildata_pinjaman->row_array();
        $jmltotalpinjaman = $rpinjaman['jmltotalpinjam'];

        if ($_FILES['uploadbukti']['name']) {
            $config = array(
                'upload_path' => './assets/upload/buktipeminjaman/', //nama folder di root
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'file_name' => strtolower(date('dmy', strtotime($tgl)) . $nopeminjaman)
            );
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadbukti')) {
                $pesan = [
                    'validasi' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error !</strong> ' . $this->upload->display_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('peminjamanuang/detaildata/' . $nopeminjaman, 'refresh');
            } else {
                $media = $this->upload->data();
                $pathbukitbaru = './assets/upload/buktipeminjaman/' . $media['file_name'];

                $datasimpan_detailpeminjamanuang = [
                    'nodetail' => $nopeminjaman, 'tgl' => $tgl,
                    'pilihan' => 1,
                    'jml' => $jml, 'buktifoto' => $pathbukitbaru,
                    'ket' => $ket
                ];
            }
        } else {
            $datasimpan_detailpeminjamanuang = [
                'nodetail' => $nopeminjaman, 'tgl' => $tgl,
                'pilihan' => 1,
                'jml' => $jml,
                'ket' => $ket
            ];
        }
        $simpandata = $this->db->insert('detailpinjaman_uang', $datasimpan_detailpeminjamanuang);

        //update total pinjam pada tabel pinjaman uang
        $dataupdatepinjamanuang = [
            'jmltotalpinjam' => $jmltotalpinjaman + $jml
        ];
        $this->db->where('nomor', $nopeminjaman);
        $this->db->update('pinjaman_uang', $dataupdatepinjamanuang);
        if ($simpandata) {
            $pesan = [
                'validasi' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="badge badger-success">Berhasil !</h4> Pinjaman berhasil ditambahkan...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('peminjamanuang/detaildata/' . $nopeminjaman, 'refresh');
        }
    }

    function hapusdetaildata()
    {
        $id = $this->uri->segment(3);
        $nopeminjaman = $this->uri->segment(4);

        //ambil data tabel pinjaman uang 
        $queryambildata_pinjaman = $this->db->get_where('pinjaman_uang', ['nomor' => $nopeminjaman]);
        $rpinjaman = $queryambildata_pinjaman->row_array();
        $jmltotalpinjaman = $rpinjaman['jmltotalpinjam'];
        $jmltotalbayar = $rpinjaman['jmltotalbayar'];

        //ambil data detail peminjaman uang
        $qdetail = $this->db->get_where('detailpinjaman_uang', ['iddetail' => $id]);
        $rdetail = $qdetail->row_array();
        $pathbuktifoto = $rdetail['buktifoto'];
        $jml = $rdetail['jml'];
        $pilihan = $rdetail['pilihan'];

        if ($pilihan == 1) {
            $dataupdate = [
                'jmltotalpinjam' => $jmltotalpinjaman - $jml
            ];
        } else {
            $dataupdate = [
                'jmltotalbayar' => $jmltotalbayar - $jml
            ];
        }

        //hapus data
        $this->db->delete('detailpinjaman_uang', ['iddetail' => $id]);
        @unlink($pathbuktifoto);

        $this->db->where('nomor', $nopeminjaman);
        $this->db->update('pinjaman_uang', $dataupdate);

        $pesan = [
            'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <h4 class="badge badger-success">Berhasil !</h4> Detail data berhasil terhapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
        ];
        $this->session->set_flashdata($pesan);
        redirect('peminjamanuang/detaildata/' . $nopeminjaman, 'refresh');
    }

    function formtambahpembayaran()
    {
        if ($this->input->is_ajax_request() == true) {
            $nopeminjaman = $this->input->post('nomor', true);
            $data = [
                'nopeminjaman' => $nopeminjaman
            ];
            $this->load->view('peminjamanuang/modalformtambahpembayaran', $data);
        } else {
            redirect('peminjamanuang/data', 'refresh');
        }
    }
    function simpandetailpembayaran(){
        $nopeminjaman = $this->input->post('nopeminjaman', true);
        $tgl = $this->input->post('tgl', true);
        $jml = $this->input->post('jml', true);
        $ket = $this->input->post('ket', true);

        //ambil data tabel pinjaman uang 
        $queryambildata_pinjaman = $this->db->get_where('pinjaman_uang', ['nomor' => $nopeminjaman]);
        $rpinjaman = $queryambildata_pinjaman->row_array();
        $jmltotalbayar = $rpinjaman['jmltotalbayar'];

        if ($_FILES['uploadbukti']['name']) {
            $config = array(
                'upload_path' => './assets/upload/buktipembayaran/', //nama folder di root
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'file_name' => strtolower(date('dmy', strtotime($tgl)) . $nopeminjaman)
            );
            $this->load->library('upload');
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('uploadbukti')) {
                $pesan = [
                    'validasi' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error !</strong> ' . $this->upload->display_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('peminjamanuang/detaildata/' . $nopeminjaman, 'refresh');
            } else {
                $media = $this->upload->data();
                $pathbukitbaru = './assets/upload/buktipembayaran/' . $media['file_name'];

                $datasimpan_detailpeminjamanuang = [
                    'nodetail' => $nopeminjaman, 'tgl' => $tgl,
                    'pilihan' => 2,
                    'jml' => $jml, 'buktifoto' => $pathbukitbaru,
                    'ket' => $ket
                ];
            }
        } else {
            $datasimpan_detailpeminjamanuang = [
                'nodetail' => $nopeminjaman, 'tgl' => $tgl,
                'pilihan' => 2,
                'jml' => $jml,
                'ket' => $ket
            ];
        }


        $simpandata = $this->db->insert('detailpinjaman_uang', $datasimpan_detailpeminjamanuang);

        //update total pinjam pada tabel pinjaman uang
        $dataupdatepinjamanuang = [
            'jmltotalbayar' => $jmltotalbayar + $jml
        ];
        $this->db->where('nomor', $nopeminjaman);
        $this->db->update('pinjaman_uang', $dataupdatepinjamanuang);
        if ($simpandata) {
            $pesan = [
                'validasi' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="badge badger-success">Berhasil !</h4> Pembayaran Hutang berhasil ditambahkan...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('peminjamanuang/detaildata/' . $nopeminjaman, 'refresh');
        }
    }
}
