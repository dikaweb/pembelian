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

        //$data['menu'] = $this->db->query('select * from m_gudang a inner join m_company b on a.id_company = b.id_company order by nm_company')->result_array();
        $data['lokasi'] = $this->db->query('select * from lokasi where id not in (1,18,19,20,21,22)')->result_array();
        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_gudang1', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('messagez', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function changesubAccess()
    {
        $id_company = $this->input->post('id_company');
        $id_lokasi = $this->input->post('id_lokasi');
        $lokasi = $this->input->post('lokasi');

        $data = [
            'id_lokasi' => $id_lokasi,
            'id_company' => $id_company
        ];

        $result = $this->db->get_where('m_gudang', $data);

        if ($result->num_rows() < 1) {
            $row = $this->db->get_where('m_company', ['id_company' => $id_company])->row_array();
            $data2 = [
                'id_lokasi' => $id_lokasi,
                'id_company' => $id_company,
                'kd_gudang' => $lokasi . ' ' . $row['kode_c'],
                'is_active' => 1
            ];
            $this->db->insert('m_gudang', $data2);
        } else {
            $this->db->delete('m_gudang', $data);
        }

        $this->session->set_flashdata('messagez', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }
}
