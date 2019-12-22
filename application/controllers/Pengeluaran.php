<?php
class Pengeluaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true) {
            $this->load->library(['pagination', 'form_validation']);
            $this->load->model('Modeljenispengeluaran', 'pengeluaran');
            $this->load->model('Modeljenispengeluaranx', 'pengeluaranx');
            return true;
        } else {

            redirect('login/keluar', 'refresh');
        }
    }
    public function datajenis()
    {
        $data = [];
        $view = [
            'judul' => 'Manajemen Data Jenis Pengeluaran',
            'isi' => $this->load->view('pengeluaran/jenis/index', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }

    public function ambildatajenispengeluaran()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->pengeluaran->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->jenis;
                $row[] = '<button type="button" class="btn btn-danger" onclick="return hapus(' . $field->id . ')"><i class="fa fa-trash"></i></button>';
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->pengeluaran->count_all(),
                "recordsFiltered" => $this->pengeluaran->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function tambahdatajenis()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $this->load->view('pengeluaran/jenis/formtambahdata');
        }
    }

    function simpandatajenis()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $namajenis = $this->input->post('namajenis', true);

            $this->form_validation->set_rules('namajenis', 'Nama Jenis', 'trim|required', array(
                'required' => '%s tidak boleh kosong'
            ));


            if ($this->form_validation->run() == true) {
                $datasimpan = [
                    'jenis' => $namajenis
                ];
                $this->db->insert('jenispengeluaran', $datasimpan);
                $msg = [
                    'sukses' => 'Data berhasil tersimpan'
                ];
            } else {
                $msg = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h4>Error !</h4> ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
            }
            echo json_encode($msg);
        }
    }

    function hapusjenis()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $id = $this->input->post('id', true);
            $this->db->delete('jenispengeluaran', ['id' => $id]);
        }
    }

    //Untuk Input Pengeluaran
    function input()
    {
        $data = [];
        $view = [
            'judul' => 'Input Pengeluaran',
            'isi' => $this->load->view('pengeluaran/forminput', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }
    function ambildatapengeluaran()
    {
        if ($this->input->is_ajax_request() == TRUE) {
            $list = $this->pengeluaranx->get_datatables();
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $field) {
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $field->tglpengeluaran;
                $row[] = $field->namapengeluaran;
                $row[] = number_format($field->jmlpengeluaran, 0, ",", ".");
                $row[] = $field->jenis;
                $row[] = '<button type="button" onclick="return hapus(' . $field->idpengeluaran . ')" class="btn btn-outline-danger"><i class="fa fw fa-trash-alt"></i></button><button type="button" onclick="return edit(' . $field->idpengeluaran . ')" class="btn btn-outline-info"><i class="fa fw fa-pencil-alt"></i></button>';
                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->pengeluaranx->count_all(),
                "recordsFiltered" => $this->pengeluaranx->count_filtered(),
                "data" => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        } else {
            exit('data tidak bisa dieksekusi');
        }
    }

    function tambahdatapengeluaran()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $data['datajenis'] = $this->db->get('jenispengeluaran');
            $this->load->view('pengeluaran/formtambahdatapengeluaran', $data);
        }
    }

    function simpandatapengeluaran()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $tgl = $this->input->post('tgl', true);
            $nama = $this->input->post('nama', true);
            $jml = $this->input->post('jml', true);
            $jenis = $this->input->post('jenis', true);

            $namafile = rand(1, 9999) . date('dmY', strtotime($tgl));

            if ($_FILES['uploadbukti']['name'] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipengeluaran/', //nama folder di root
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 0,
                    'max_width' => 0,
                    'max_height' => 0,
                    'file_name' => $namafile
                );
                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('uploadbukti')) {
                    echo $this->upload->display_errors();
                } else {
                    $media = $this->upload->data();
                    $pathbukitbaru = './assets/upload/buktipengeluaran/' . $media['file_name'];

                    $datasimpan = [
                        'tglpengeluaran' => $tgl,
                        'namapengeluaran' => $nama, 'jmlpengeluaran' => $jml,
                        'uploadbukti' => $pathbukitbaru, 'jenisid' => $jenis
                    ];
                }
            } else {
                $datasimpan = [
                    'tglpengeluaran' => $tgl,
                    'namapengeluaran' => $nama, 'jmlpengeluaran' => $jml,
                    'jenisid' => $jenis
                ];
            }
            $simpan = $this->db->insert('pengeluaran', $datasimpan);
            if ($simpan) {
                echo 'berhasil';
            }
        }
    }

    function hapusdata()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $id = $this->input->post('id', true);
            //ambildata

            $ambildata = $this->db->get_where('pengeluaran', ['idpengeluaran' => $id]);
            $row = $ambildata->row_array();
            $pathbukti = $row['uploadbukti'];

            $this->db->delete('pengeluaran', ['idpengeluaran' => $id]);
            @unlink($pathbukti);
        }
    }

    function edit()
    {
        $id = $this->input->post('id', true);
        $ambildata = $this->db->get_where('pengeluaran', ['idpengeluaran' => $id]);
        $row = $ambildata->row_array();
        $data = [
            'id' => $id,
            'tgl' => $row['tglpengeluaran'],
            'nama' => $row['namapengeluaran'],
            'jml' => $row['jmlpengeluaran'],
            'idjenis' => $row['jenisid'],
            'bukti' => $row['uploadbukti'],
            'datajenis' => $this->db->get('jenispengeluaran')
        ];
        $this->load->view('pengeluaran/formeditpengeluaran', $data);
    }

    function updatedatapengeluaran()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $id = $this->input->post('id', true);
            $tgl = $this->input->post('tgl', true);
            $nama = $this->input->post('nama', true);
            $jml = $this->input->post('jml', true);
            $jenis = $this->input->post('jenis', true);

            $namafile = rand(1, 9999) . date('dmY', strtotime($tgl));

            $ambildata = $this->db->get_where('pengeluaran', ['idpengeluaran' => $id]);
            $row = $ambildata->row_array();
            $pathlama = $row['uploadbukti'];

            if ($_FILES['uploadbukti']['name'] != NULL) {
                $config = array(
                    'upload_path' => './assets/upload/buktipengeluaran/', //nama folder di root
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size' => 0,
                    'max_width' => 0,
                    'max_height' => 0,
                    'file_name' => $namafile
                );
                $this->load->library('upload');
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('uploadbukti')) {
                    echo $this->upload->display_errors();
                } else {
                    @unlink($pathlama);

                    $media = $this->upload->data();
                    $pathbukitbaru = './assets/upload/buktipengeluaran/' . $media['file_name'];

                    $dataupdate = [
                        'tglpengeluaran' => $tgl,
                        'namapengeluaran' => $nama, 'jmlpengeluaran' => $jml,
                        'uploadbukti' => $pathbukitbaru, 'jenisid' => $jenis
                    ];
                }
            } else {
                $dataupdate = [
                    'tglpengeluaran' => $tgl,
                    'namapengeluaran' => $nama, 'jmlpengeluaran' => $jml,
                    'jenisid' => $jenis
                ];
            }
            $this->db->where('idpengeluaran', $id);
            $simpan = $this->db->update('pengeluaran', $dataupdate);
            if ($simpan) {
                echo 'berhasil';
            }
        }
    }
    //end
}