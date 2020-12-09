<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cari_surat extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $data['title'] = 'Cari Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $data['company'] = $this->db->get('m_company')->result_array();
        //$data['lokasi'] = $this->db->get('lokasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_cari_surat', $data);
    }

    public function cari($keyword)
    {
        $keyword = str_replace("~", " ", $keyword);
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_user = $row['id'];
        $id_lokasi = $row['id_lokasi'];
        $id_dept = $row['id_dept'];

        $v_all = $this->session->flashdata('v_all'); //session ini diambil dari helper 
        $v_all_lokasi = $this->session->flashdata('v_all_lokasi'); //session ini diambil dari helper 
        $v_all_dept = $this->session->flashdata('v_all_dept'); //session ini diambil dari helper 

        //jika admin
        if ($v_all == 1) {
            $query = " select id_surat,no_surat,tgl_upload,judul_surat,nm_dept,lokasi,nm_company,
            SUBSTRING(`isi_surat`, GREATEST(LOCATE('$keyword',`isi_surat`) - 20, 1), 
                LEAST(45, LENGTH(isi_surat) - GREATEST(LOCATE('$keyword',`isi_surat`) - 20, 1)))
            as isi_surat,is_pdf,status   from surat a
            left join m_dept b on a.id_dept = b.id_dept
            left join lokasi c on a.id_lokasi = c.id
            left join m_company e on a.id_company = e.id_company
            where a.isi_surat like '%$keyword%' order by id_surat
            ";
        }

        //jika manager
        if ($v_all == 0 && $v_all_dept == 1) {
            $query = " select id_surat,no_surat,tgl_upload,judul_surat,nm_dept,lokasi,nm_company,
            SUBSTRING(`isi_surat`, GREATEST(LOCATE('$keyword',`isi_surat`) - 20, 1), 
                LEAST(45, LENGTH(isi_surat) - GREATEST(LOCATE('$keyword',`isi_surat`) - 20, 1)))
            as isi_surat,is_pdf,status from surat a
            left join m_dept b on a.id_dept = b.id_dept
            left join lokasi c on a.id_lokasi = c.id
            left join m_company e on a.id_company = e.id_company
            where  (a.id_dept = $id_dept or a.id_user = $id_user) and a.isi_surat like '%$keyword%'
            order by id_surat
            ";
        }

        //jika user
        if ($v_all == 0 && $v_all_dept == 0) {
            $query = " select id_surat,no_surat,tgl_upload,judul_surat,nm_dept,lokasi,nm_company,
            SUBSTRING(`isi_surat`, GREATEST(LOCATE('$keyword',`isi_surat`) - 20, 1), 
                LEAST(45, LENGTH(isi_surat) - GREATEST(LOCATE('$keyword',`isi_surat`) - 20, 1)))
            as isi_surat,is_pdf,status from surat a
            left join m_dept b on a.id_dept = b.id_dept
            left join lokasi c on a.id_lokasi = c.id
            left join m_company e on a.id_company = e.id_company
            where  a.id_user = $id_user and a.isi_surat like '%$keyword%' order by id_surat
            ";
        }

        $data['konfirmasi'] = $this->db->query($query)->result_array();
        $this->load->view('surat/v_modal_cari_surat', $data);
    }
}
