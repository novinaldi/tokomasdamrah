<?php
class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true) {
            return true;
        } else {

            redirect('login/keluar', 'refresh');
        }
    }

    function index(){
        $x = [
            'judul' => 'Selamat Datang '.$this->session->userdata('namauser'),
            'isi' => $this->load->view('home/index','',true)
        ];
        $this->parser->parse('template/index',$x);
    }
}
