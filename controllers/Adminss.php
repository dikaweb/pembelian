<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function insert_role()
    {
        $nama_role = $this->input->post('role');
        $this->db->insert('user_role', array('role' => $nama_role));
        $url = 'admin/role' . $id_transaksi;
        redirect($url);
    }
    public function user_role()
    {
        $data['title'] = 'User Group Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->load->model('User_role_model', 'u_role');
        $data['u_role'] = $this->u_role->getSubMenu();

        $this->load->model('user_role_model');
        $simpan_update = $this->user_role_model;

        $data['cbo_role'] = $this->u_role->cbo_role();

        $validasi = $this->form_validation;
        $validasi->set_rules($simpan_update->rules());


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/user_role', $data);
            $this->load->view('templates/footer');
        } else {
            $simpan_update->update_user_role();
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Rekanan No :!</div>');
            redirect('admin/user_role');
        }
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Group Role & Menu Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function rolesubAccess($role_id, $submenu_id)
    {
        $data['title'] = 'Group Role & Sub Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get_where('user_menu', ['id' => $submenu_id])->row_array();
        $data['submenu'] = $this->db->get_where('user_sub_menu', ['menu_id' => $submenu_id])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role-sub-access', $data);
        $this->load->view('templates/footer');
    }


    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function changesubAccess()
    {

        $submenu_id = $this->input->post('submenuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'sub_menu_id' => $submenu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function get_user_role()
    {
        $this->load->model('User_role_model');
        echo json_encode($this->User_role_model->getSubMenubyid($_POST['id']));
        //$this->Mahasiswa_model->getAllMahasiswa();
        //echo ($_POST['id']);
        //->getSubMenubyid($_POST['id']));
        //echo json_encode('tes');
    }

    public function update_company_user()
    {
        $id_company = $this->input->post('id_company');
        $nm_company = $this->input->post('nm_company');
        $id_user = $this->input->post('id_user');
        $this->id_company = $id_company;
        $this->db->update("user", $this, array('id' => $id_user));
    }
}
