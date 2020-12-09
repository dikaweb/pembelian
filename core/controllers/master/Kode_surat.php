<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kode_surat extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Kode Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

        $query = "select * from m_kode a 
        inner join m_dept b on a.id_dept = b.id_dept
        inner join m_company c on a.id_company = c.id_company
        ";
        $data['menu'] = $this->db->query($query)->result_array();
        $data['dept'] = $this->db->get('m_dept')->result_array();
        $data['company'] = $this->db->get('m_company')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('master/v_kode_surat', $data);
            // $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');
        $this->id_company = trim(htmlspecialchars($this->input->post('company')));
        $this->id_dept = trim(htmlspecialchars($this->input->post('dept')));
        $this->jml_kode = trim(htmlspecialchars($this->input->post('jml_kode')));
        $this->penghubung = trim(htmlspecialchars($this->input->post('penghubung')));
        $this->db->update('m_kode', $this, array('id_kode' => $id));

        $jml = $this->input->post('jml_kode');
        $query = "delete from m_kode_d where id_kode = $id and no_urut > $jml";
        $this->db->query($query);

        $query = "select max(no_urut) as max_id from m_kode_d where id_kode = $id ";
        $row = $this->db->query($query)->row_array();
        $urut_max = $row['max_id'];

        if ($jml > $urut_max) {
            for ($x = $urut_max + 1; $x <= $jml; $x += 1) {
                $query = "insert into m_kode_d (id_kode,no_urut)values($id,$x)";
                $this->db->query($query);
            }
        }
        redirect('master/kode_surat');
    }
    public function delete()
    {
        $id = $this->input->post('idd');
        $this->db->delete('m_kode_d', array('id_kode' => $id));
        $this->db->delete('m_kode', array('id_kode' => $id));
        redirect('master/kode_surat');
    }
    public function save()
    {
        $this->id_company = trim(htmlspecialchars($this->input->post('companyt')));
        $this->id_dept = trim(htmlspecialchars($this->input->post('deptt')));
        $this->jml_kode = trim(htmlspecialchars($this->input->post('jml_kodet')));
        $this->penghubung = trim(htmlspecialchars($this->input->post('penghubungt')));
        $this->db->insert('m_kode', $this);

        $query = "select max(id_kode) as max_id from m_kode ";
        $row = $this->db->query($query)->row_array();
        $id_kode = $row['max_id'];

        $jml = $this->input->post('jml_kodet');
        for ($x = 1; $x <= $jml; $x += 1) {
            $query = "insert into m_kode_d (id_kode,no_urut)values($id_kode,$x)";
            $this->db->query($query);
        }
        redirect('master/kode_surat');
    }

    public function detil($id_kode)
    {
        $data['title'] = 'Kode Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

        $data['kode_tipe'] = $this->db->get('m_kode_tipe')->result_array();
        $query = "select * from m_kode a
        inner join m_dept b on a.id_dept = b.id_dept
        inner join m_company c on a.id_company = c.id_company
        inner join m_kode_d d on a.id_kode = d.id_kode 
        left join m_kode_tipe e on d.id_kode_tipe = e.id_kode_tipe
        where a.id_kode = $id_kode
        ";
        $data['menu'] = $this->db->query($query)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/v_kode_surat_detil', $data);
        $this->load->view('templates/footer');
    }

    public function save_detil()
    {
        $id_kode = $this->input->post('idm');
        $id = $this->input->post('idd');
        $this->id_kode_tipe = $this->input->post('dept');
        $this->db->update('m_kode_d', $this, array('id_kode_d' => $id));
        redirect('master/kode_surat/detil/' . $id_kode);
    }
}
