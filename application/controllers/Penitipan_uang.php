<?php
class Penitipan_uang extends CI_Controller
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
            'judul' => 'Input Penitipan Uang',
            'isi' => $this->load->view('penitipanuang/forminput', '', true)
        ];
        $this->parser->parse('template/index', $view);
    }

    //Cari Pelanggan
    function caripelanggan()
    {
        $this->load->view('penitipanuang/vcaripelanggan');
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

    //End Cari Pelanggan

    function simpandata()
    {
        $nopenitipan = $this->input->post('nopenitipan', true);
        $tglpenitipan = $this->input->post('tglpenitipan', true);
        $nikpel = $this->input->post('nikpel', true);
        $jmluang = $this->input->post('jmluang', true);

        $ket = $this->input->post('ket', true);

        $this->form_validation->set_rules('nopenitipan', 'No.Penitipan', 'trim|required|is_unique[nn_titipuang.notitip]', array(
            'is_unique' => '%s yang diinputkan sudah ada didalam database, silahkan coba dengan nomor yang lain'
        ));

        if ($this->form_validation->run() == true) {
            if ($_FILES["uploadbukti"]["name"] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipenitipan/', //nama folder di root
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
                    redirect('penitipan-uang/index', 'refresh');
                } else {
                    $media = $this->upload->data();
                    $pathfotobaru = './assets/upload/buktipenitipan/' . $media['file_name'];

                    $datasimpan = [
                        'notitip' => $nopenitipan,
                        'tglawal' => $tglpenitipan, 'pelnik' => $nikpel, 'jmlawal' => $jmluang,
                        'jmlsisa' => $jmluang
                        // 'buktifoto' => $pathfotobaru,
                        // 'ket' => $ket
                    ];

                    $datasimpandetail = [
                        'notitip' => $nopenitipan, 'tgl' => $tglpenitipan, 'pilihan' => 1, 'nominal' => $jmluang,
                        // 'jmlsaldo' => $jmluang,
                        'buktifoto' => $pathfotobaru,
                        'ket' => $ket
                    ];
                }
            } else {
                $datasimpan = [
                    'notitip' => $nopenitipan,
                    'tglawal' => $tglpenitipan, 'pelnik' => $nikpel, 'jmlawal' => $jmluang,
                    'jmlsisa' => $jmluang,
                    // 'ket' => $ket
                ];
                $datasimpandetail = [
                    'notitip' => $nopenitipan, 'tgl' => $tglpenitipan, 'pilihan' => 1, 'nominal' => $jmluang,
                    // 'jmlsaldo' => $jmluang,
                    'ket' => $ket
                ];
            }

            $simpandata = $this->db->insert('nn_titipuang', $datasimpan);
            $simpandatadetail = $this->db->insert('nn_detailtitipuang', $datasimpandetail);
            if ($simpandata && $simpandatadetail) {
                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Berhasil !</strong> Data penitipan berhasil tersimpan, silahkan klik tombol cek data
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipan-uang/index', 'refresh');
            }
        } else {
            $pesan = [
                'pesan' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ' . validation_errors() . '
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipan-uang/index', 'refresh');
        }
    }

    function data()
    {
        $tombol_cari = $this->input->post('btncari', true);
        if (isset($tombol_cari)) {
            $cari = $this->input->post('cari', true);
            $this->session->set_userdata('caripenitipanuang', $cari);

            redirect('penitipan-uang/data');
        } else {
            $cari = $this->session->userdata('caripenitipanuang');
        }

        //Query data
        $q = "SELECT nn_titipuang.`notitip` AS nomor,jmlsisa,DATE_FORMAT(nn_titipuang.tglawal,'%d-%m-%Y') AS tglawal,
        pelanggan.`pelnik`,pelnama,jmlawal,stt FROM nn_titipuang INNER JOIN pelanggan ON pelanggan.`pelnik`=nn_titipuang.`pelnik` 
        WHERE notitip LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY notitip DESC";

        $query_data = $this->db->query($q);
        //end Query data

        $total_data = $query_data->num_rows();
        //Ini Konfigurasi Pagination
        $config['base_url'] = site_url('penitipan-uang/data/');
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


        $qx = "SELECT nn_titipuang.`notitip` AS nomor,jmlsisa,DATE_FORMAT(nn_titipuang.tglawal,'%d-%m-%Y') AS tglawal,
        pelanggan.`pelnik`,pelnama,jmlawal,stt FROM nn_titipuang INNER JOIN pelanggan ON pelanggan.`pelnik`=nn_titipuang.`pelnik` 
        WHERE notitip LIKE '%$cari%' OR pelnama LIKE '%$cari%' ORDER BY notitip DESC LIMIT " . $start . ',' . $per_page;

        $query_data_per_page = $this->db->query($qx);
        //end Query data perpage

        $data = array(
            'totaldata' => $config['total_rows'],
            'cari' => $cari,
            'tampildata' => $query_data_per_page
        );
        $view = [
            'judul' => 'Seluruh Data Penitipan Uang Pelanggan',
            'isi' => $this->load->view('penitipanuang/vseluruhdata', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }

    function hapusdata()
    {
        $no = $this->uri->segment(3);

        //cek data penitipan uang
        $cekdata = $this->db->get_where('nn_titipuang', ['notitip' => $no]);
        if ($cekdata->num_rows() > 0) {
            $ambildatadetail = $this->db->get_where('nn_detailtitipuang', ['notitip' => $no]);

            foreach ($ambildatadetail->result_array() as $rdetail) {
                $pathbuktix = $rdetail['buktifoto'];
                @unlink($pathbuktix);
            }

            //hapus detail titip uang
            $this->db->trans_start();
            $this->db->delete('nn_detailtitipuang', ['notitip' => $no]);
            $this->db->delete('nn_titipuang', ['notitip' => $no]);
            $this->db->trans_complete();




            if ($this->db->trans_status() == true) {
                $pesan = [
                    'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <span class="badge badge-success">Berhasil !</span> Data data penitipan berhasil terhapus
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
                $this->session->set_flashdata($pesan);
                redirect('penitipan-uang/data', 'refresh');
            }
        } else {
            redirect('penitipan-uang/data', 'refresh');
        }
    }

    function detaildata()
    {
        $no = $this->uri->segment(3);

        //cek data penitipan uang
        $cekdata = $this->db->get_where('nn_titipuang', ['notitip' => $no]);
        if ($cekdata->num_rows() > 0) {
            $r = $cekdata->row_array();

            //ambil data pelanggan 
            $datapelanggan = $this->db->get_where('pelanggan', ['pelnik' => $r['pelnik']]);
            $rpel = $datapelanggan->row_array();

            $data = [
                'notitip' => $r['notitip'], 'tgl' => date('d-m-Y', strtotime($r['tglawal'])),
                'pelanggan' => $r['pelnik'] . ' / ' . $rpel['pelnama'],
                'jml' => number_format($r['jmlawal'], 0),
                'sisa' => number_format($r['jmlsisa'], 0),
                'stt' => $r['stt']
            ];
            $view = [
                'judul' => 'Detail Data Penitipan Uang',
                'isi' => $this->load->view('penitipanuang/vdetaildata', $data, true)
            ];
            $this->parser->parse('template/index', $view);
        } else {
            redirect('penitipan-uang/data', 'refresh');
        }
    }

    function hapusdetaildata()
    {
        $id = $this->uri->segment(3);
        $no = $this->uri->segment(4);

        //ambil data detail penitipan 
        $ambildetail = $this->db->get_where('nn_detailtitipuang', ['iddetail' => $id]);
        $a = $ambildetail->row_array();
        $pilihan = $a['pilihan'];
        $nominal = $a['nominal'];
        $pathbukti = $a['buktifoto'];

        //hapus detail 
        $this->db->delete('nn_detailtitipuang', ['iddetail' => $id]);
        @unlink($pathbukti);
        //ambil data penitipan
        $ambildatapenitipan = $this->db->get_where('nn_titipuang', ['notitip' => $no]);
        $b = $ambildatapenitipan->row_array();
        $totalpenitipan = $b['jmlawal'];
        $sisapenitipan = $b['jmlsisa'];

        //update jumlah titipan atau sisa
        if ($pilihan == 1) {
            $dataupdate = [
                'jmlawal' => $totalpenitipan - $nominal,
                'jmlsisa' => $sisapenitipan - $nominal,
                'stt' => 0
            ];
        } else {
            $dataupdate = [
                'jmlawal' => $sisapenitipan + $nominal,
                'jmlsisa' => $sisapenitipan + $nominal,
                'stt' => 0
            ];
        }
        $this->db->where('notitip', $no);
        $this->db->update('nn_titipuang', $dataupdate);

        $pesan = [
            'pesan' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="badge badge-success">Berhasil !</span> Data berhasil terhapus
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
        ];
        $this->session->set_flashdata($pesan);
        redirect('penitipan-uang/detaildata/' . $no, 'refresh');
    }

    function formtambahpenitipan()
    {
        if ($this->input->is_ajax_request() == true) {
            $notitip = $this->input->post('notitip', true);
            $data = ['notitip' => $notitip];
            $this->load->view('penitipanuang/formtambahtitipan', $data);
        } else {
            exit('maaf tidak ada respon...');
        }
    }

    function simpandetailpenitipan()
    {
        $notitip = $this->input->post('notitip', true);
        $tgl = $this->input->post('tgl', true);
        $jml = $this->input->post('jml', true);
        $ket = $this->input->post('ket', true);

        //ambil data dari tabel nn_titipuang
        $querytabeltitipuang = $this->db->get_where('nn_titipuang', ['notitip' => $notitip]);
        $datatitipuang = $querytabeltitipuang->row_array();
        $jmlsisatitipuang = $datatitipuang['jmlsisa'];

        //ambil id terakhir dari transaksi detail
        // $querydetail = "SELECT jmlsaldo FROM nn_detailtitipuang ORDER BY iddetail DESC LIMIT 1";
        // $querydata = $this->db->query($querydetail);
        // $rdetail = $querydata->row_array();
        // $jmlsaldoawal = $rdetail['jmlsaldo'];

        if ($_FILES['uploadbukti']['name'] != NULL) {
            $config = array(
                'upload_path' => './assets/upload/buktipenitipan/', //nama folder di root
                'allowed_types' => 'jpg|jpeg|png',
                'max_size' => 0,
                'max_width' => 0,
                'max_height' => 0,
                'file_name' => strtolower(date('dmy', strtotime($tgl)) . $notitip)
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
                redirect('penitipan-uang/detaildata/' . $notitip, 'refresh');
            } else {
                $media = $this->upload->data();
                $pathfotobaru = './assets/upload/buktipenitipan/' . $media['file_name'];


                $datasimpandetail = [
                    'notitip' => $notitip, 'tgl' => $tgl, 'pilihan' => 1, 'nominal' => $jml,
                    'buktifoto' => $pathfotobaru,
                    'ket' => $ket,
                    // 'jmlsaldo' => $jmlsaldoawal + $jml
                ];
            }
        } else {
            $datasimpandetail = [
                'notitip' => $notitip, 'tgl' => $tgl, 'pilihan' => 1, 'nominal' => $jml,
                'ket' => $ket,
                // 'jmlsaldo' => $jmlsaldoawal + $jml
            ];
        }

        $this->db->insert('nn_detailtitipuang', $datasimpandetail);
        //update jumlah sisa pada tabel titipuang
        $dataupdatetitipuang = [
            'jmlsisa' => $jmlsisatitipuang + $jml
        ];
        $this->db->where('notitip', $notitip);
        $this->db->update('nn_titipuang', $dataupdatetitipuang);
        //end

        $pesan = [
            'validasi' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="badge badge-success">Berhasil !</span> Penitipan Berhasil di tambahkan...
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>'
        ];
        $this->session->set_flashdata($pesan);
        redirect('penitipan-uang/detaildata/' . $notitip, 'refresh');
    }

    function formtambahpengambilan()
    {
        if ($this->input->is_ajax_request() == true) {
            $notitip = $this->input->post('notitip', true);
            $data = ['notitip' => $notitip];
            $this->load->view('penitipanuang/formtambahpengambilan', $data);
        } else {
            exit('maaf tidak ada respon...');
        }
    }

    function simpandetailpengambilan()
    {
        $notitip = $this->input->post('notitip', true);
        $tgl = $this->input->post('tgl', true);
        $jml = $this->input->post('jml', true);
        $ket = $this->input->post('ket', true);

        //ambil data dari tabel nn_titipuang
        $querytabeltitipuang = $this->db->get_where('nn_titipuang', ['notitip' => $notitip]);
        $datatitipuang = $querytabeltitipuang->row_array();
        $jmlsisatitipuang = $datatitipuang['jmlsisa'];

        //ambil id terakhir dari transaksi detail
        // $querydetail = "SELECT jmlsaldo FROM nn_detailtitipuang ORDER BY iddetail DESC LIMIT 1";
        // $querydata = $this->db->query($querydetail);
        // $rdetail = $querydata->row_array();
        // $jmlsaldoawal = $rdetail['jmlsaldo'];

        if ($jml > $jmlsisatitipuang) {
            //Tampilkan error jika jumlah yang diinput > dari jml sisa
            $pesan = [
                'validasi' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error !</strong> Maaf Jumlah Pengambilan yang diinput melebih sisa yang ada...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipan-uang/detaildata/' . $notitip, 'refresh');
        } else {
            if ($_FILES['uploadbukti']['name'] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipengambilan/', //nama folder di root
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 0,
                    'max_width' => 0,
                    'max_height' => 0,
                    'file_name' => strtolower(date('dmy', strtotime($tgl)) . $notitip)
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
                    redirect('penitipan-uang/detaildata/' . $notitip, 'refresh');
                } else {
                    $media = $this->upload->data();
                    $pathfotobaru = './assets/upload/buktipengambilan/' . $media['file_name'];


                    $datasimpandetail = [
                        'notitip' => $notitip, 'tgl' => $tgl, 'pilihan' => 2, 'nominal' => $jml,
                        'buktifoto' => $pathfotobaru,
                        'ket' => $ket,
                        // 'jmlsaldo' => $jmlsaldoawal - $jml
                    ];
                }
            } else {
                $datasimpandetail = [
                    'notitip' => $notitip, 'tgl' => $tgl, 'pilihan' => 2, 'nominal' => $jml,
                    'ket' => $ket,
                    // 'jmlsaldo' => $jmlsaldoawal - $jml
                ];
            }

            $this->db->insert('nn_detailtitipuang', $datasimpandetail);
            //update jumlah sisa pada tabel titipuang
            //Ubah status Penitipan jika sudah habis diambil
            if ($jml == $jmlsisatitipuang) {
                $dataupdatetitipuang = [
                    'jmlsisa' => $jmlsisatitipuang - $jml,
                    'stt' => 1
                ];
            } else {
                $dataupdatetitipuang = [
                    'jmlsisa' => $jmlsisatitipuang - $jml
                ];
            }
            $this->db->where('notitip', $notitip);
            $this->db->update('nn_titipuang', $dataupdatetitipuang);
            //end


            $pesan = [
                'validasi' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="badge badge-success">Berhasil !</span> Pengambilan Berhasil di tambahkan...
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>'
            ];
            $this->session->set_flashdata($pesan);
            redirect('penitipan-uang/detaildata/' . $notitip, 'refresh');
        }
    }

    function tampilkanbuktifoto()
    {
        $id = $this->input->post('id', true);
        $q = $this->db->get_where('nn_detailtitipuang', ['iddetail' => $id]);
        $r = $q->row_array();

        $data = [
            'buktifoto' => $r['buktifoto']
        ];
        $this->load->view('penitipanuang/modallihatbuktifoto', $data);
    }
}