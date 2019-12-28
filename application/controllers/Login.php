<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['form_validation']);
    }

    function index()
    {
        $x = [
            // 'isi' => $this->load->view('login/index', '', true)
        ];

        $this->parser->parse('template/login', $x);
    }
    function validasiuser()
    {
        $iduser = $this->input->post('uid', TRUE);
        $pass = $this->input->post('pass', TRUE);

        $this->form_validation->set_rules(
            'uid',
            'Username',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );

        $this->form_validation->set_rules(
            'pass',
            'Password',
            'trim|required',
            array(
                'required' => '%s tidak boleh kosong'
            )
        );


        if ($this->form_validation->run() == TRUE) {
            //cek user
            $cekuser = $this->db->get_where('users', ['userid' => $iduser]);
            if ($cekuser->num_rows() > 0) {
                $row = $cekuser->row_array();

                //ambildata level 
                $datalevel = $this->db->get_where('levels', ['levelid' => $row['userlevelid']]);
                $rlevel = $datalevel->row_array();

                $hashpass = $row['userpass'];
                if (password_verify($pass, $hashpass)) {
                    $ses_array = [
                        'masuk' => true,
                        'iduser' => $iduser,
                        'namauser' => $row['usernama'],
                        'foto' => $row['userfoto'],
                        'id' => $row['id'],
                        'namalevel' => $rlevel['levelnama'],
                        'idlevel' => $rlevel['levelid']
                    ];
                    $this->session->set_userdata($ses_array);
                } else {
                    $err = [
                        'pesan' => '
                        <div class="alert alert-danger" role="alert"><strong>
                        Maaf..password anda tidak benar</strong>
                        </div>
                        '
                    ];
                    $this->session->set_flashdata($err);
                    redirect('login/index', 'refresh');
                }
            } else {
                $err = [
                    'pesan' => '
                    <div class="alert alert-danger" role="alert"><strong>
                    Maaf User tidak ditemukan</strong>
                    </div>
                    '
                ];
                $this->session->set_flashdata($err);

                redirect('login/index', 'refresh');
            }
        } else {
            $err = [
                'pesan' => '
                <div class="alert alert-danger" role="alert"><strong>
                ' . validation_errors() . '</strong>
                </div>
                '
            ];
            $this->session->set_flashdata($err);

            redirect('login/index', 'refresh');
        }

        if ($this->session->userdata('masuk') == TRUE) {

            redirect('home/index', 'refresh');
        } else {
            $this->index();
        }
    }

    function keluar()
    {
        $this->session->sess_destroy();

        redirect('login/index', 'refresh');
    }
}