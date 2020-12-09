<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {

        if ($this->session->userdata('usernamez')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validasinya success
            $this->_login();
        }
    }


    private function _login()
    {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));

        $user = $this->db->get_where('user', ['username' => $email])->row_array();

        // jika usernya ada
        if ($user) {
            // jika usernya aktif

            // cek password
            if ($password == $user['password']) {
                $data = [
                    'usernamez' => $user['username'],
                    'role_idz' => $user['role_id'],
                    'id_loginz' => $user['id']
                ];
                $this->session->set_userdata($data);
                if ($user['role_id'] == 1) {
                    redirect('admin/role');
                } else {
                    redirect('user');
                }
            } else {
                $this->session->set_flashdata('messagez', '<div class="alert alert-danger" role="alert">Wrong password!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('messagez', '<div class="alert alert-danger" role="alert">Email is not registered!</div>');
            redirect('auth');
        }
    }




    public function logout()
    {
        $this->session->unset_userdata('usernamez');
        $this->session->unset_userdata('role_idz');
        $this->session->unset_userdata('id_loginz');
        $this->session->set_flashdata('messagez', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }


    public function blocked()
    {
        $this->load->view('auth/blocked');
    }
}
