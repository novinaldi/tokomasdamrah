<?php
class Test extends CI_Controller{
    function index(){
        $query = "SELECT tgl,
        CASE jenis WHEN 'M' THEN jumlah ELSE 0 END AS masuk,
        CASE jenis WHEN 'K' THEN jumlah ELSE 0 END AS keluar
        FROM testdummy ORDER BY tgl ASC";
        $data['tampil'] = $this->db->query($query)->result();
        $this->load->view('test/index',$data);
    }
}