<?php
class Pengeluaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true) {
            $this->load->library(['pagination', 'form_validation']);
            $this->load->model('Modeljenispengeluaran', 'pengeluaran');
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

    function tambahdata()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $this->load->view('pengeluaran/formtambahdata');
        }
    }
}