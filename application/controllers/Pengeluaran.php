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
                $row[] = '';
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
            $this->load->view('pengeluaran/formtambahdatapengeluaran');
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

            $namafile = rand(1, 9999) . date(dmY, strtotime($tgl));

            if ($_FILES['uploadbukti']['name'] != NULL) {
                echo 'ada';
            } else {
                echo 'tidak ada';
            }
        }
    }
    //end
}