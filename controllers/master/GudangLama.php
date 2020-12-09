<?php
defined('BASEPATH') or exit('No direct script access allowed');

class gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Gudang';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        $data['menu'] = $this->db->query('select * from m_gudang a inner join m_company b on a.id_company = b.id_company order by nm_company')->result_array();
        $data['company'] = $this->db->get('m_company')->result_array();
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_gudang', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('messagez', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $this->kd_gudang = trim(htmlspecialchars($this->input->post('nama')));
        $this->ket_gd = trim(htmlspecialchars($this->input->post('ket')));
        $this->alamat_gd = trim(htmlspecialchars($this->input->post('alamat')));
        $this->alamat_gd = trim(htmlspecialchars($this->input->post('alamat')));
        $this->id_company = $this->input->post('txt_company');
        $this->is_outstanding = $this->input->post('is_outstanding');
        $this->is_kapasan = $this->input->post('is_kapasan');
        $this->db->update('m_gudang', $this, array('id_gudang' => $id));
        redirect('master/gudang');
    }
    public function delete()
    {
        $id = $this->input->post('idd');
        $this->db->delete('m_gudang', array('id_gudang' => $id));
        redirect('master/gudang');
    }
    public function save()
    {
        $this->kd_gudang = trim(htmlspecialchars($this->input->post('namat')));
        $this->ket_gd = trim(htmlspecialchars($this->input->post('kett')));
        $this->alamat_gd = trim(htmlspecialchars($this->input->post('alamatt')));
        $this->alamat_gd = trim(htmlspecialchars($this->input->post('alamatt')));
        $this->id_company = $this->input->post('txt_companyt');
        if ($this->input->post('is_outstandingt') <> null) {
            $is_outstanding = $this->input->post('is_outstandingt');
        } else {
            $is_outstanding = 0;
        };
        $this->is_outstanding = $is_outstanding;

        //var_dump($this->input->post('is_kapasant'));
        //die();
        if ($this->input->post('is_kapasant') <> null) {
            $is_kapasan = $this->input->post('is_kapasant');
        } else {
            $is_kapasan = 0;
        };

        $this->is_kapasan = $is_kapasan;

        $this->db->insert('m_gudang', $this);
        redirect('master/gudang');
    }
}
