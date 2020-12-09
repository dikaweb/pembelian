<?php
defined('BASEPATH') or exit('No direct script access allowed');

class company extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Company';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

        $data['menu'] = $this->db->get('m_company')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_company', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $this->nm_company = trim(htmlspecialchars($this->input->post('nama')));
        $this->jalan_c = trim(htmlspecialchars($this->input->post('alamat')));
        $this->kota_c = trim(htmlspecialchars($this->input->post('kota')));
        $this->kode_c = trim(htmlspecialchars($this->input->post('kode')));
        $this->db->update('m_company', $this, array('id_company' => $id));
        redirect('master/company');
    }
    public function delete()
    {
        $id = $this->input->post('idd');
        $this->db->delete('m_company', array('id_company' => $id));
        redirect('master/company');
    }
    public function save()
    {
        $this->nm_company = trim(htmlspecialchars($this->input->post('namat')));
        $this->jalan_c = trim(htmlspecialchars($this->input->post('alamatt')));
        $this->kota_c = trim(htmlspecialchars($this->input->post('kotat')));
        $this->kode_c = trim(htmlspecialchars($this->input->post('kodet')));
        $this->db->insert('m_company', $this);
        redirect('master/company');
    }
}
