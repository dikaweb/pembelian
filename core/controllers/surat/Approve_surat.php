<?php
defined('BASEPATH') or exit('No direct script access allowed');

class approve_surat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {

        $data['title'] = 'Approve Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id = $row['id'];
        $id_lokasi = $row['id_lokasi'];
        $id_dept = $row['id_dept'];

        $v_all = $this->session->flashdata('v_all'); //session ini diambil dari helper 
        $v_all_lokasi = $this->session->flashdata('v_all_lokasi'); //session ini diambil dari helper 
        $v_all_dept = $this->session->flashdata('v_all_dept'); //session ini diambil dari helper 

        //jika admin
        if ($v_all == 1) {
            $query = " select * from surat a
        left join m_dept b on a.id_dept = b.id_dept
        left join lokasi c on a.id_lokasi = c.id
        left join user d on a.id_user = d.id
        left join m_company e on a.id_company = e.id_company
        left join status f on a.status = f.id_status
        where a.status < 2 
        order by a.no_urut
        ";
        }

        //jika manager
        if ($v_all == 0 && $v_all_dept == 1) {
            $query = " select * from surat a
            left join m_dept b on a.id_dept = b.id_dept
            left join lokasi c on a.id_lokasi = c.id
            left join user d on a.id_user = d.id
            left join m_company e on a.id_company = e.id_company
            left join status f on a.status = f.id_status
            where a.status < 2 and  a.id_dept = $id_dept 
            order by a.no_urut
            ";
        }
        $data['do_m'] = $this->db->query($query)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_approve_surat', $data);
    }

    public function approve()
    {
        $post = $this->input->post();
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_user = $row['id'];
        $id_transaksi = $post["id_transaksi"];
        $my_date = date("Y-m-d H:i:s");
        $this->db->query("update surat set approve1 = $id_user, tgl_app1 = '$my_date'
        ,status = 5 where id_surat = $id_transaksi ");
        echo json_encode(true);
    }

    public function downloaddoc($id_surat)
    {

        $row = $this->db->get_where('surat', ['id_surat' => $id_surat])->row_array();
        $id_user = $row['id_user'];
        $no_surat = $row['no_surat'];
        $no_surat_file = str_replace("/", "#", $no_surat);

        ////////////////////////////////////////////
        $namabaru = $no_surat_file . '.docx';
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./assets/docx/' . $namabaru);
        //$templateProcessor->setImageValue('ttd', array('path' => './images/stempel2.png', 'width' => 100, 'height' => 100, 'ratio' => false));
        $templateProcessor->setImageValue('qrcode', array('path' => './assets/img/qrcode/' . $no_surat_file . '.png', 'width' => 85, 'height' => 85, 'ratio' => false));
        $templateProcessor->setImageValue('kop', array('path' => './images/kopsurat.jpg', 'width' => 900, 'ratio' => true));
        $templateProcessor->setValue('no_surat', $no_surat);
        $templateProcessor->saveAs("./assets/docx_temp/" . $id_user . ".docx");
        $this->load->helper('download');
        force_download("./assets/docx_temp/" . $id_user . ".docx", NULL);
    }

    public function reject()
    {
        $id = $this->input->post('id_transaksi');
        $this->db->query("delete from surat where id_surat = $id");
        echo json_encode(true);
    }
}
