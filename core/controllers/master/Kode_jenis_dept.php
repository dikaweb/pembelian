<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kode_jenis_dept extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Jenis Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();




        $this->db->join('m_company', 'm_company.id_company=m_kode_jenis_dept.id_company', 'left');
        $this->db->join('m_dept', 'm_dept.id_dept=m_kode_jenis_dept.id_dept', 'left');
        $data['menu'] = $this->db->get('m_kode_jenis_dept')->result_array();
        $data['dept'] = $this->db->get('m_dept')->result_array();
        $data['company'] = $this->db->get('m_company')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_kode_jenis_dept', $data);
            //$this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function update()
    {
        $id = $this->input->post('id');
        $this->nm_kode_jenis_dept = trim(htmlspecialchars($this->input->post('nama')));
        $this->ket_kode_jenis_dept = trim(htmlspecialchars($this->input->post('ket')));
        $this->id_dept = $this->input->post('dept');
        $this->id_company = $this->input->post('company');
        $this->db->update('m_kode_jenis_dept', $this, array('id_kode_jenis_dept' => $id));
        redirect('master/kode_jenis_dept');
    }
    public function delete()
    {
        $id = $this->input->post('idd');
        $this->db->delete('m_kode_jenis_dept', array('id_kode_jenis_dept' => $id));
        redirect('master/kode_jenis_dept');
    }
    public function save()
    {
        $this->nm_kode_jenis_dept = trim(htmlspecialchars($this->input->post('namat')));
        $this->ket_kode_jenis_dept = trim(htmlspecialchars($this->input->post('kett')));
        $this->id_dept = $this->input->post('deptt');
        $this->id_company = $this->input->post('companyt');
        $this->db->insert('m_kode_jenis_dept', $this);
        redirect('master/kode_jenis_dept');
    }
}
