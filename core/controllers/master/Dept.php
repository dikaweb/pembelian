<?php
defined('BASEPATH') or exit('No direct script access allowed');

class dept extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Departement';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

        $data['menu'] = $this->db->get('m_dept')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_dept', $data);
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
        $this->nm_dept = trim(htmlspecialchars($this->input->post('nama')));
        $this->ket_d = trim(htmlspecialchars($this->input->post('ket')));
        $this->kode_d = trim(htmlspecialchars($this->input->post('kode')));
        $this->db->update('m_dept', $this, array('id_dept' => $id));
        redirect('master/dept');
    }
    public function delete()
    {
        $id = $this->input->post('idd');
        $this->db->delete('m_dept', array('id_dept' => $id));
        redirect('master/dept');
    }
    public function save()
    {
        $this->nm_dept = trim(htmlspecialchars($this->input->post('namat')));
        $this->ket_d = trim(htmlspecialchars($this->input->post('kett')));
        $this->kode_d = trim(htmlspecialchars($this->input->post('kodet')));
        $this->db->insert('m_dept', $this);
        redirect('master/dept');
    }
}
