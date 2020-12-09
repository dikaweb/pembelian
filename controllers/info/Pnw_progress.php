<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Pnw_progress extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("trans/penawaran_model");
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_company = $row['id_company'];
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-180 days', strtotime($datenow)));
        $this->session->set_flashdata('messagex', $this->session->flashdata('messagey'));
        $this->session->set_flashdata('no_pr', $this->session->flashdata('no_pr'));
        $url = 'info/pnw_progress/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Penawaran Progress';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        $this->session->set_flashdata('no_pr', $this->session->flashdata('no_pr'));
        if ($id_company == 0) {
            $query = " select *,a.id,DATE_FORMAT(a.date_time, '%Y-%m-%d') as tgl_pr, 
        (select sum(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) as jml_penawaran,
        (select sum(is_po) from permintaan_barang_detail where permintaan_barang_id = a.id) as jml_po,
        (select count(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) as jml_detil
        from permintaan_barang a
        left join m_company b on a.id_company = b.id_company
        left join m_nopol c on a.id_nopol = c.id_nopol
        inner join lokasi d on a.lokasi_id = d.id
        inner join user e on a.user_id = e.id
        inner join permintaan_barang_proses g on a.id = g.permintaan_barang_id
        where a.date_time  between '$startDate' and '$endDate' and  g.status ='submitted' 
        and (select sum(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) > 0
        and ((select count(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) <> (select sum(is_po) from permintaan_barang_detail where permintaan_barang_id = a.id))
        order by a.id desc";
            $data['kota'] = 'ALL';
        } else {
            $query = " select *,a.id,DATE_FORMAT(a.date_time, '%Y-%m-%d') as tgl_pr, 
            (select sum(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) as jml_penawaran,
            (select sum(is_po) from permintaan_barang_detail where permintaan_barang_id = a.id) as jml_po,
            (select count(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) as jml_detil
            from permintaan_barang a
            left join m_company b on a.id_company = b.id_company
            left join m_nopol c on a.id_nopol = c.id_nopol
            inner join lokasi d on a.lokasi_id = d.id
            inner join user e on a.user_id = e.id
            inner join permintaan_barang_proses g on a.id = g.permintaan_barang_id
        where a.id_company = $id_company and a.date_time  between '$startDate' and '$endDate' and  g.status ='submitted' 
        and (select sum(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) > 0
        and ((select count(is_penawaran) from permintaan_barang_detail where permintaan_barang_id = a.id) <> (select sum(is_po) from permintaan_barang_detail where permintaan_barang_id = a.id))
           order by a.id desc";
            $data['dipilih'] = $this->db->get_where('m_company', ['id_company' => $id_company])->row_array();
            $data['kota'] = $data['dipilih']['nm_company'];
        }

        $querytbl = " select * from m_company";
        $data['tombol'] = $this->db->query($querytbl)->result_array();

        $data['konfirmasi'] = $this->db->query($query)->result_array();
        $this->session->set_flashdata('messagez', $this->session->flashdata('messagex'));
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_penawaran', $data);
        // $this->load->view('templates/footer');
    }
}
