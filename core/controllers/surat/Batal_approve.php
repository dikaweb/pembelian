<?php

use FontLib\Table\Type\post;

defined('BASEPATH') or exit('No direct script access allowed');

class batal_approve extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-30 days', strtotime($datenow)));
        $url = 'surat/batal_approve/view/' . $dateawal . '/' . $datenow;
        redirect($url);
    }

    public function view($startDate, $endDate)
    {
        $data['title'] = 'Batal Approve';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();

        $query = " select * from surat a
        left join m_dept b on a.id_dept = b.id_dept
        left join lokasi c on a.id_lokasi = c.id
        left join user d on a.id_user = d.id
        left join m_company e on a.id_company = e.id_company
        left join status f on a.status = f.id_status
        where a.status = 5 and a.tgl_upload  between '$startDate' and '$endDate' 
        order by a.no_urut
        ";

        $data['do_m'] = $this->db->query($query)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_batal_approve', $data);
    }

    public function batal()
    {
        $id = $this->input->post('idd');
        $this->db->query("update surat set status = 1,is_pdf = 0 where id_surat = $id");
        redirect('surat/batal_approve');
    }
}
