<?php
class Penitipanemas extends CI_Controller
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
        $data = [
            'tampiljenisemas' => $this->db->get('jenisemas')
        ];
        $view = [
            'judul' => 'Input Penitipan Emas Pelanggan',
            'isi' => $this->load->view('penitipanemas/forminput', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }
    function caripelanggan()
    {
        $this->load->view('penitipanemas/vcaripelanggan');
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
        $nopenitipan = $this->input->post('nopenitipan', true);
        $tglpenitipan = $this->input->post('tglpenitipan', true);
        $nikpel = $this->input->post('nikpel', true);
        $jenisemas = $this->input->post('jenisemas', true);
        $jmlpenitipan = $this->input->post('jmlpenitipan', true);
        $ket = $this->input->post('ket', true);

        $this->form_validation->set_rules('nopenitipan', 'No.Penitipan', 'trim|required|is_unique[penitipanemas.notitip]', array(
            'is_unique' => '%s yang diinputkan sudah ada didalam database, silahkan coba dengan nomor yang lain'
        ));

        $this->form_validation->set_rules('jmlpenitipan', 'Inputan Jml Penitipan', 'trim|required|decimal', array(
            'decimal' => '%s harus bilang desimal, 2 angka dibelakang koma'
        ));
        if ($this->form_validation->run() == TRUE) {
            if ($_FILES['uploadbukti']['name'] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipenitipanemas/', //nama folder di root
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 0,
                    'max_width' => 0,
                    'max_height' => 0,
                    'file_name' => strtolower(date('dmy', strtotime($tglpenitipan)) . $nopenitipan)
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
                    redirect('penitipanemas/index', 'refresh');
                } else {
                    $media = $this->upload->data();
                    $pathbukitbaru = './assets/upload/buktipenitipanemas/' . $media['file_name'];

                    $datasimpan_penitipanemas = [
                        'notitip' => $nopenitipan, 'tglawal' => $tglpenitipan,
                        'pelnik' => $nikpel, 'totaltitipan' => $jmlpenitipan,
                    ];

                    $datasimpan_detailpenitipanemas = [
                        'notitip' => $nopenitipan, 'tgl' => $tglpenitipan,
                        'idjenis' => $jenisemas, 'buktifoto' => $pathbukitbaru, 'ket' => $ket,
                        'jml' => $jmlpenitipan, 'pilihan' => 1
                    ];
                }
            } else {
                $datasimpan_penitipanemas = [
                    'notitip' => $nopenitipan, 'tglawal' => $tglpenitipan,
                    'pelnik' => $nikpel, 'totaltitipan' => $jmlpenitipan,
                ];

                $datasimpan_detailpenitipanemas = [
                    'notitip' => $nopenitipan, 'tgl' => $tglpenitipan,
                    'idjenis' => $jenisemas, 'ket' => $ket,
                    'jml' => $jmlpenitipan, 'pilihan' => 1
                ];
            }

            $this->db->trans_start();
            $this->db->insert('penitipanemas', $datasimpan_penitipanemas);
            $this->db->insert('detail_penitipanemas', $datasimpan_detailpenitipanemas);
            $this->db->trans_complete();

            if ($this->db->trans_status() == true) {
                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Berhasil</h4> No.Penitipan : <strong>' . $nopenitipan . '</strong> berhasil disimpan, silahkan cek data dengan mengklik Tombol Lihat Data
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipanemas/index', 'refresh');
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
            redirect('penitipanemas/index', 'refresh');
        }
    }

    function data()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripenitipanemas', $cari);

            redirect('penitipanemas/data');
        } else {
            $cari = $this->session->userdata('caripenitipanemas');
        }

        //Query data
        $q = "SELECT notitip,tglawal,CONCAT(pelanggan.`pelnik`,'/',pelanggan.`pelnama`) AS pelanggan,totaltitipan,totalambil FROM penitipanemas JOIN pelanggan ON pelanggan.pelnik=penitipanemas.`pelnik` WHERE notitip LIKE '%$cari%' OR pelanggan.`pelnik` LIKE '%$cari%' OR pelanggan.`pelnama` LIKE '%$cari%' ORDER BY tglawal DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('penitipanemas/data/');
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


        $qx = "SELECT notitip,tglawal,CONCAT(pelanggan.`pelnik`,'/',pelanggan.`pelnama`) AS pelanggan,totaltitipan,totalambil FROM penitipanemas JOIN pelanggan ON pelanggan.pelnik=penitipanemas.`pelnik` WHERE notitip LIKE '%$cari%' OR pelanggan.`pelnik` LIKE '%$cari%' OR pelanggan.`pelnama` LIKE '%$cari%' ORDER BY tglawal DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Seluruh Data Penitipan Emas Pelanggan',
            'isi' => $this->load->view('penitipanemas/vseluruhdata', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }
    function hapusdata()
    {
        $nopenitipan = $this->uri->segment(3);

        $q = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
        if ($q->num_rows() > 0) {
            //hapus patch foto

            $qdetail = $this->db->get_where('detail_penitipanemas', ['notitip' => $nopenitipan]);
            $jmldatadetail = $qdetail->num_rows();

            foreach ($qdetail->result_array() as $r) {
                $pathbukti = $r['buktifoto'];
                @unlink($pathbukti);
            }

            $this->db->delete('detail_penitipanemas', ['notitip' => $nopenitipan]);
            $this->db->delete('penitipanemas', ['notitip' => $nopenitipan]);

            $pesan = [
                'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Berhasil</h4> Semua data dengan No.Penitipan : ' . $nopenitipan . ' telah dihapus
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipanemas/data', 'refresh');
        } else {
            redirect('penitipanemas/data', 'refresh');
        }
    }

    function detaildata()
    {
        $nopenitipan = $this->uri->segment(3);

        //Menampilkan masing total titipan masing-masing jenis
        $querytotaltitipan = $this->db->query("SELECT (SELECT IFNULL((SUM(IF(pilihan=1,jml,0))-SUM(IF(pilihan=2,jml,0))),0) FROM detail_penitipanemas WHERE idjenis=1) AS total_mas_antam,
        (SELECT IFNULL((SUM(IF(pilihan=1,jml,0))-SUM(IF(pilihan=2,jml,0))),0) FROM detail_penitipanemas WHERE idjenis=2) AS total_mas_murni,
        (SELECT IFNULL((SUM(IF(pilihan=1,jml,0))-SUM(IF(pilihan=2,jml,0))),0) FROM detail_penitipanemas WHERE idjenis=3) AS total_perhiasan FROM
        detail_penitipanemas WHERE notitip = '$nopenitipan' GROUP BY notitip");

        $d_total = $querytotaltitipan->row_array();
        $total_mas_antam = $d_total['total_mas_antam'];
        $total_mas_murni = $d_total['total_mas_murni'];
        $total_perhiasan = $d_total['total_perhiasan'];
        //end

        $q = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
        if ($q->num_rows() > 0) {
            $r = $q->row_array();
            $pelnik = $r['pelnik'];

            $qpel = $this->db->get_where('pelanggan', ['pelnik' => $pelnik]);
            $rpel = $qpel->row_array();

            $data = [
                'total_masantam' => $total_mas_antam,
                'total_masmurni' => $total_mas_murni,
                'total_perhiasan' => $total_perhiasan,
                'nopenitipan' => $r['notitip'], 'tglawal' => date('d-m-Y', strtotime($r['tglawal'])),
                'pelanggan' => $r['pelnik'] . ' / ' . $rpel['pelnama'],
                'totaltitipan' => number_format($r['totaltitipan'], 2, ",", "."), 'totalambil' => number_format($r['totalambil'], 2, ",", ".")
            ];
            $view = [
                'judul' => 'Detail Penitipan Emas Pelanggan',
                'isi' => $this->load->view('penitipanemas/vdetaildata', $data, true)
            ];
            $this->parser->parse('template/index', $view);
        } else {
            redirect('penitipanemas/data', 'refresh');
        }
    }

    function tampilkanbuktifoto()
    {
        $id = $this->input->post('id', true);
        $q = $this->db->get_where('detail_penitipanemas', ['id' => $id]);
        $r = $q->row_array();

        $data = [
            'buktifoto' => $r['buktifoto']
        ];
        $this->load->view('penitipanemas/modallihatbuktifoto', $data);
    }

    function tambahpenitipan()
    {
        if ($this->input->is_ajax_request()) {
            $nopenitipan = $this->input->post('no', true);
            //cek data 
            $query = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
            if ($query->num_rows() > 0) {
                $data = [
                    'nopenitipan' => $nopenitipan,
                    'datajenisemas' => $this->db->get('jenisemas')
                ];
                $this->load->view('penitipanemas/modalformtambahpenitipan', $data);
            } else {
                redirect('penitipanemas/data');
            }
        } else {
            redirect('penitipanemas/data');
        }
    }

    function tambahpengambilan()
    {
        if ($this->input->is_ajax_request()) {
            $nopenitipan = $this->input->post('no', true);
            // echo $nopenitipan;
            //cek data 
            $query = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
            if ($query->num_rows() > 0) {
                $data = [
                    'nopenitipan' => $nopenitipan,
                    'datajenisemas' => $this->db->get('jenisemas')
                ];
                $this->load->view('penitipanemas/modalformtambahpengambilan', $data);
            } else {
                redirect('penitipanemas/data');
            }
        } else {
            redirect('penitipanemas/data');
        }
    }

    function simpandetailpenitipan()
    {
        $nopenitipan = $this->input->post('nopenitipan', true);
        $tgl = $this->input->post('tgl', true);
        $jml = $this->input->post('jml', true);
        $jenisemas = $this->input->post('jenis', true);
        $ket = $this->input->post('ket', true);


        $this->form_validation->set_rules('jml', 'Inputan Jumlah', 'trim|required|decimal', array(
            'decimal' => '%s harus dalam bentuk angka decimal, gunakan tanda titik'
        ));

        if ($this->form_validation->run() == true) {
            if ($_FILES['uploadbukti']['name'] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipenitipanemas/', //nama folder di root
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 0,
                    'max_width' => 0,
                    'max_height' => 0,
                    'file_name' => strtolower(date('dmy', strtotime($tgl)) . $nopenitipan . rand(1, 999))
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
                    redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
                } else {
                    $media = $this->upload->data();
                    $pathbukitbaru = './assets/upload/buktipenitipanemas/' . $media['file_name'];

                    $datasimpandetail = [
                        'notitip' => $nopenitipan, 'tgl' => $tgl, 'idjenis' => $jenisemas,
                        'pilihan' => 1, 'jml' => $jml, 'buktifoto' => $pathbukitbaru,
                        'ket' => $ket
                    ];
                }
            } else {
                $datasimpandetail = [
                    'notitip' => $nopenitipan, 'tgl' => $tgl, 'idjenis' => $jenisemas,
                    'pilihan' => 1, 'jml' => $jml,
                    'ket' => $ket
                ];
            }

            //tambah jumlah titipan pada table penitipanemas
            $ambildatapenitipan = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
            $row = $ambildatapenitipan->row_array();
            $totaltitipan = $row['totaltitipan'];

            //update
            $dataupdatepenitipanemas = ['totaltitipan' => $totaltitipan + $jml];
            $this->db->where('notitip', $nopenitipan);
            $this->db->update('penitipanemas', $dataupdatepenitipanemas);

            //insert ke tabel detail

            $simpan = $this->db->insert('detail_penitipanemas', $datasimpandetail);
            if ($simpan) {
                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Berhasil Tersimpan</h4> Data penitipan berhasil ditambahkan
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
            }
        } else {
            $pesan = [
                'pesan' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error</h4> ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
        }
    }

    function simpandetailpengambilan()
    {
        $nopenitipan = $this->input->post('nopenitipan', true);
        $tgl = $this->input->post('tgl', true);
        $jml = $this->input->post('jml', true);
        $jenisemas = $this->input->post('jenis', true);
        $ket = $this->input->post('ket', true);


        $this->form_validation->set_rules('jml', 'Inputan Jumlah', 'trim|required|decimal', array(
            'decimal' => '%s harus dalam bentuk angka decimal, gunakan tanda titik'
        ));

        if ($this->form_validation->run() == true) {

            //Menampilkan masing total titipan masing-masing jenis
            $querytotaltitipan = $this->db->query("SELECT (SELECT IFNULL((SUM(IF(pilihan=1,jml,0))-SUM(IF(pilihan=2,jml,0))),0) FROM detail_penitipanemas WHERE idjenis=1) AS total_mas_antam,
        (SELECT IFNULL((SUM(IF(pilihan=1,jml,0))-SUM(IF(pilihan=2,jml,0))),0) FROM detail_penitipanemas WHERE idjenis=2) AS total_mas_murni,
        (SELECT IFNULL((SUM(IF(pilihan=1,jml,0))-SUM(IF(pilihan=2,jml,0))),0) FROM detail_penitipanemas WHERE idjenis=3) AS total_perhiasan FROM
        detail_penitipanemas WHERE notitip = '$nopenitipan' GROUP BY notitip");

            $d_total = $querytotaltitipan->row_array();
            $total_mas_antam = $d_total['total_mas_antam'];
            $total_mas_murni = $d_total['total_mas_murni'];
            $total_perhiasan = $d_total['total_perhiasan'];
            //end

            if ($jenisemas == 1 && $jml > $total_mas_antam) {
                $pesan = [
                    'validasi' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Maaf</h4> Jumlah yang di Inputan Untuk Mengambil Mas Antam melebihi dari yang ada...
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
            }
            if ($jenisemas == 2 && $jml > $total_mas_murni) {
                $pesan = [
                    'validasi' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Maaf</h4> Jumlah yang di Inputan Untuk Mengambil Mas Murni melebihi dari yang ada...
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
            }
            if ($jenisemas == 3 && $jml > $total_perhiasan) {
                $pesan = [
                    'validasi' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4 class="alert-heading">Maaf</h4> Jumlah yang di Inputan Untuk Mengambil Perhiasan melebihi dari yang ada...
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
            } else {
                if ($_FILES['uploadbukti']['name'] != NULL) {
                    $config = array(
                        'upload_path' => './assets/upload/buktipengambilanemas/', //nama folder di root
                        'allowed_types' => 'jpg|jpeg|png',
                        'max_size' => 0,
                        'max_width' => 0,
                        'max_height' => 0,
                        'file_name' => strtolower(date('dmy', strtotime($tgl)) . $nopenitipan . rand(1, 999))
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
                        redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
                    } else {
                        $media = $this->upload->data();
                        $pathbukitbaru = './assets/upload/buktipengambilanemas/' . $media['file_name'];

                        $datasimpandetail = [
                            'notitip' => $nopenitipan, 'tgl' => $tgl, 'idjenis' => $jenisemas,
                            'pilihan' => 2, 'jml' => $jml, 'buktifoto' => $pathbukitbaru,
                            'ket' => $ket
                        ];
                    }
                } else {
                    $datasimpandetail = [
                        'notitip' => $nopenitipan, 'tgl' => $tgl, 'idjenis' => $jenisemas,
                        'pilihan' => 2, 'jml' => $jml,
                        'ket' => $ket
                    ];
                }

                //tambah jumlah pengambilan pada table penitipanemas
                $ambildatapenitipan = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
                $row = $ambildatapenitipan->row_array();
                $totalambil = $row['totalambil'];

                //update
                $dataupdatepenitipanemas = ['totalambil' => $totalambil + $jml];
                $this->db->where('notitip', $nopenitipan);
                $this->db->update('penitipanemas', $dataupdatepenitipanemas);

                //insert ke detail
                $simpandata = $this->db->insert('detail_penitipanemas', $datasimpandetail);
                if ($simpandata) {
                    $pesan = [
                        'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Berhasil</h4> Pengambilan Emas berhasil ditambahkan
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>'
                    ];
                    $this->session->set_flashdata($pesan);
                    redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
                }
            }
        } else {
            $pesan = [
                'pesan' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error</h4> ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
        }
    }

    function hapusdetaildata()
    {
        $id = $this->uri->segment(3);
        $nopenitipan = $this->uri->segment(4);

        //ambildata penitipan
        $ambildatapenitipan = $this->db->get_where('penitipanemas', ['notitip' => $nopenitipan]);
        $rdata = $ambildatapenitipan->row_array();
        $totaltitipan = $rdata['totaltitipan'];
        $totalambil = $rdata['totalambil'];

        //ambildata detail penitipan
        $ambildata = $this->db->get_where('detail_penitipanemas', ['id' => $id]);
        $r = $ambildata->row_array();
        $pathbukti = $r['buktifoto'];
        $pilihan = $r['pilihan'];
        $jml = $r['jml'];

        @unlink($pathbukti);
        
        $hapusdetail = $this->db->delete('detail_penitipanemas', ['id' => $id]);


        //Lakukan update total
        if ($pilihan == 1) {
            $dataupdatepenitipan = [
                'totaltitipan' => $totaltitipan - $jml
            ];
        } else {
            $dataupdatepenitipan = [
                'totalambil' => $totalambil - $jml
            ];
        }
        $this->db->where('notitip', $nopenitipan);
        $this->db->update('penitipanemas', $dataupdatepenitipan);

        if ($hapusdetail) {
            $pesan = [
                'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Berhasil</h4><hr> Detail data berhasil terhapus
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipanemas/detaildata/' . $nopenitipan, 'refresh');
        }
    }
}
