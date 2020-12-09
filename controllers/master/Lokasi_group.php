<?php
defined('BASEPATH') or exit('No direct script access allowed');

class lokasi_group extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Lokasi Group';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('emailz')])->row_array();

        $query = "select * from lokasi_group
        ";
        $data['menu'] = $this->db->query($query)->result_array();
        $data['dept'] = $this->db->get('m_dept')->result_array();
        $data['company'] = $this->db->get('m_company')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_lokasi_group', $data);
            // $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('messagez', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function edit()
    {
        $id = $this->input->post('ide');
        $this->nm_lokasi_group = trim(htmlspecialchars($this->input->post('nm_lokasi_groupe')));
        $this->db->update('lokasi_group', $this, array('id_lokasi_group' => $id));

        redirect('master/lokasi_group');
    }
    public function delete()
    {
        $id = $this->input->post('idd');
        $this->db->delete('lokasi_group', array('id_lokasi_group' => $id));
        redirect('master/lokasi_group');
    }
    public function save()
    {
        $this->nm_lokasi_group = trim(htmlspecialchars($this->input->post('nm_lokasi_group')));
        $this->db->insert('lokasi_group', $this);

        redirect('master/lokasi_group');
    }

    public function detil($id_kode)
    {
        $data['title'] = 'Lokasi Group';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('emailz')])->row_array();

        $query = "select * from lokasi_group_d a inner join lokasi b on a.id_lokasi = b.id
        inner join lokasi_group c on  a.id_lokasi_group = c.id_lokasi_group
        where a.id_lokasi_group = $id_kode
        ";
        $data['menu'] = $this->db->query($query)->result_array();
        $data['lokasi'] = $this->db->query('select * from lokasi')->result_array();
        $data['id_kode'] = $id_kode;

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/v_lokasi_group_detil', $data);
        $this->load->view('templates/footer');
    }

    public function save_d()
    {
        $id_kode = $this->input->post('idm');
        $this->id_lokasi = $this->input->post('lokasit');
        $this->id_lokasi_group = $this->input->post('idm');
        $this->db->insert('lokasi_group_d', $this);
        redirect('master/lokasi_group/detil/' . $id_kode);
    }

    public function delete_d()
    {
        $id = $this->input->post('idd');
        $id_kode = $this->input->post('idmd');
        $this->db->delete('lokasi_group_d', array('id_detail' => $id));
        redirect('master/lokasi_group/detil/' . $id_kode);
    }
}
