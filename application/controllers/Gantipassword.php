<?php
class Gantipassword extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('masuk') == true) {
            $this->load->library([
                'form_validation'
            ]);
            return true;
        } else {
            redirect('login/index');
        }
    }
    public function index()
    {
        $x = [
            'judul' => 'Form Ganti Password',
            'isi' => $this->load->view('gantipassword/form', '', true)
        ];
        $this->parser->parse('template/index', $x);
    }

    function change()
    {
        if (!$this->input->is_ajax_request()) {
            $this->index();
        } else {
            $iduser = $this->session->userdata('iduser');
            $idlevel = $this->session->userdata('idlevel');
            $passlama = $this->input->post('passlama', true);
            $passbaru = $this->input->post('passbaru', true);
            $ulangi = $this->input->post('ulangipassbaru', true);

            $this->form_validation->set_rules('passlama', 'Password Lama', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('passbaru', 'Password Baru', 'trim|required', [
                'required' => '%s tidak boleh kosong'
            ]);
            $this->form_validation->set_rules('ulangipassbaru', 'Ulangi Password', 'trim|required|matches[passbaru]', [
                'required' => '%s tidak boleh kosong',
                'matches' => 'Inputan %s harus sama dengan di atas'
            ]);


            if ($this->form_validation->run() == true) {
                //cek password lama 
                if ($idlevel == 1) {
                    $ambildatauser = $this->db->get_where('users', ['userid' => $iduser]);
                    $r_datauser = $ambildatauser->row_array();
                    $passadminlama = $r_datauser['userpass'];

                    if (password_verify($passlama, $passadminlama)) {
                        $hash_passbaru = password_hash($passbaru, PASSWORD_BCRYPT);

                        $datapassuseradmin = [
                            'userpass' => $hash_passbaru
                        ];

                        $this->db->where('userid', $iduser);
                        $this->db->update('users', $datapassuseradmin);
                        $pesan = [
                            'sukses' => 'Berhasil'
                        ];
                    } else {
                        $pesan = [
                            'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            Sepertinya <strong>Password Lama</strong> yang anda isi salah, silahkan ulangi kembali
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>'
                        ];
                    }
                }
            } else {
                $pesan = [
                    'error' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ' . validation_errors() . '
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>'
                ];
            }

            echo json_encode($pesan);
        }
    }
}