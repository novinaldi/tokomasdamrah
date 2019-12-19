<?php
class Pelanggan2 extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Modelpelanggan','pelanggan');
    }

    function index()
    {

        $data['tampildata'] = $this->db->get('pelanggan');
        $view = [
            'judul' => 'Data Pelanggan',
            'isi' => $this->load->view('pelanggan/vdatatest', $data, true)
        ];
        $this->parser->parse('template/index', $view);
    }

    function ambildata()
    {
        $list = $this->pelanggan->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->cusnama;
            $row[] = $field->cusjenkel;
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
    }
}
