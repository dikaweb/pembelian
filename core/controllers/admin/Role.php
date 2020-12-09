<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {

        is_logged_in();
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $data['role'] = $this->db->get('user_role')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function insert_role()
    {
        is_logged_in();
        $nama_role = $this->input->post('role');
        $this->db->insert('user_role', array('role' => $nama_role));
        $url = 'admin/role';
        redirect($url);
    }
    public function user_role()
    {
        is_logged_in();
        $data['title'] = 'User Group Role';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

        $this->load->model('User_role_model', 'u_role');
        $data['u_role'] = $this->u_role->getSubMenu();

        $this->load->model('user_role_model');
        $simpan_update = $this->user_role_model;

        $data['cbo_role'] = $this->u_role->cbo_role();
        $data['cbo_lokasi'] = $this->u_role->cbo_lokasi();
        $data['cbo_departement'] = $this->u_role->cbo_departement();

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
            redirect('admin/role/user_role');
        }
    }

    public function roleAccess($role_id)
    {
        is_logged_in();
        $data['title'] = 'Group Role & Menu Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

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
        is_logged_in();
        $data['title'] = 'Group Role & Sub Access';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

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
        is_logged_in();
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
        is_logged_in();
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
    public function changereadonly()
    {
        is_logged_in();
        $submenu_id = $this->input->post('submenuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'sub_menu_id' => $submenu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
        } else {
            $result2 = $this->db->get_where('user_access_menu', $data)->row_array();
            if ($result2['ro'] == 1) {
                $this->ro = 0;
                $this->db->update("user_access_menu", $this, $data);
            } else {
                $this->ro = 1;
                $this->db->update("user_access_menu", $this, $data);
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }
    public function changeviewall()
    {
        is_logged_in();
        $submenu_id = $this->input->post('submenuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'sub_menu_id' => $submenu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
        } else {
            $result2 = $this->db->get_where('user_access_menu', $data)->row_array();
            if ($result2['v_all'] == 1) {
                $this->v_all = 0;
                $this->db->update("user_access_menu", $this, $data);
            } else {
                $this->v_all = 1;
                $this->db->update("user_access_menu", $this, $data);
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function changeviewalllokasi()
    {
        is_logged_in();
        $submenu_id = $this->input->post('submenuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'sub_menu_id' => $submenu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
        } else {
            $result2 = $this->db->get_where('user_access_menu', $data)->row_array();
            if ($result2['v_all_lokasi'] == 1) {
                $this->v_all_lokasi = 0;
                $this->db->update("user_access_menu", $this, $data);
            } else {
                $this->v_all_lokasi = 1;
                $this->v_all = 0;
                $this->db->update("user_access_menu", $this, $data);
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function changeviewalldept()
    {
        is_logged_in();
        $submenu_id = $this->input->post('submenuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'sub_menu_id' => $submenu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
        } else {
            $result2 = $this->db->get_where('user_access_menu', $data)->row_array();
            if ($result2['v_all_dept'] == 1) {
                $this->v_all_dept = 0;
                $this->db->update("user_access_menu", $this, $data);
            } else {
                $this->v_all_dept = 1;
                $this->v_all_lokasi = 0;
                $this->v_all = 0;
                $this->db->update("user_access_menu", $this, $data);
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

    public function get_user_role()
    {
        is_logged_in();
        $this->load->model('User_role_model');
        echo json_encode($this->User_role_model->getSubMenubyid($_POST['id']));
    }
}
