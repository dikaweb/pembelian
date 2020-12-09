<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id = $this->session->userdata('usernamez');
        $query = "SELECT a.username as username, a.nama_lengkap as name, b.role as role, a.id as id,b.id as id_role
        ,c.lokasi as lokasi
        FROM user a 
        JOIN user_role b ON a.role_id = b.id 
        left JOIN lokasi c ON a.lokasi_id = c.id 
        where username = '$id'
      ";

        $data['user2'] = $this->db->query($query)->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }
}
