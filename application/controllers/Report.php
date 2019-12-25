<?php
class Report extends CI_Controller
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
    public function index()
    {
        $view = [
            'judul' => 'Laporan',
            'isi' => $this->load->view('laporan/viewindex', '', true)
        ];
        $this->parser->parse('template/index', $view);
    }

    function pengeluaran()
    {
        $this->load->view('laporan/pengeluaran/data');
    }

    function penitipanuang()
    {
        $this->load->view('laporan/penitipanuang/data');
    }

    function penitipanemas()
    {
        $this->load->view('laporan/penitipanemas/data');
    }

    function peminjamanuang()
    {
        $this->load->view('laporan/peminjamanuang/data');
    }

    function peminjamanemas()
    {
        $this->load->view('laporan/peminjamanemas/data');
    }

    function tampillappengeluaran()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $tglawal = $this->input->post('tglawal', true);
            $tglakhir = $this->input->post('tglakhir', true);

            $querydata = $this->db->query("SELECT idpengeluaran,namapengeluaran,tglpengeluaran,jenis,jmlpengeluaran FROM pengeluaran INNER JOIN jenispengeluaran ON 
            id=jenisid WHERE tglpengeluaran BETWEEN '$tglawal' AND '$tglakhir' ORDER BY tglpengeluaran,jenis ASC");

            $data['tampildata'] = $querydata->result();
            $this->load->view('laporan/pengeluaran/tampildata', $data);
        }
    }

    function tampillappenitipanuang()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $tglawal = $this->input->post('tglawal', true);
            $tglakhir = $this->input->post('tglakhir', true);

            $querydata = $this->db->query("SELECT notitip,tglawal,pelanggan.`pelnik`,pelanggan.`pelnama` FROM nn_titipuang INNER JOIN pelanggan ON pelanggan.`pelnik`=nn_titipuang.`pelnik` WHERE tglawal BETWEEN '$tglawal' AND '$tglakhir' ORDER BY tglawal ASC");

            // var_dump($querydata->result());
            $data = [
                'tampildata' => $querydata->result()
            ];
            $this->load->view('laporan/penitipanuang/tampildata', $data);
        }
    }

    function tampillappenitipanemas()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $tglawal = $this->input->post('tglawal', true);
            $tglakhir = $this->input->post('tglakhir', true);

            $querydata = $this->db->query("SELECT notitip,tglawal,penitipanemas.`pelnik`,pelnama FROM penitipanemas INNER JOIN pelanggan ON pelanggan.`pelnik`=penitipanemas.`pelnik`
            WHERE tglawal BETWEEN '$tglawal' AND '$tglakhir' ORDER BY tglawal ASC");

            // var_dump($querydata->result());
            $data = [
                'tampildata' => $querydata->result()
            ];
            $this->load->view('laporan/penitipanemas/tampildata', $data);
        }
    }

    function tampillappeminjamanuang()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $tglawal = $this->input->post('tglawal', true);
            $tglakhir = $this->input->post('tglakhir', true);

            $querydata = $this->db->query("SELECT nomor,tglawal,nikpel,pelnama,jmltotalpinjam,jmltotalbayar FROM pinjaman_uang INNER JOIN pelanggan ON pelnik=nikpel WHERE
            tglawal BETWEEN '$tglawal' AND '$tglakhir' ORDER BY tglawal ASC");

            // var_dump($querydata->result());
            $data = [
                'tampildata' => $querydata->result()
            ];
            $this->load->view('laporan/peminjamanuang/tampildata', $data);
        }
    }

    function tampillappeminjamanemas()
    {
        if (!$this->input->is_ajax_request()) {
            exit('Not Found');
        } else {
            $tglawal = $this->input->post('tglawal', true);
            $tglakhir = $this->input->post('tglakhir', true);

            $querydata = $this->db->query("SELECT nomor,tglawal,nikpel,pelnama,jmltotalpinjam,jmltotalbayar FROM pinjaman_emas INNER JOIN pelanggan ON pelnik=nikpel WHERE
            tglawal BETWEEN '$tglawal' AND '$tglakhir' ORDER BY tglawal ASC");

            // var_dump($querydata->result());
            $data = [
                'tampildata' => $querydata->result()
            ];
            $this->load->view('laporan/peminjamanemas/tampildata', $data);
        }
    }
}