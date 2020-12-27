<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Rekap extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_company = $row['id_company'];
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-30 days', strtotime($datenow)));
        $url = 'info/rekap/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Rekap PO/SPK';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        if ($id_company == 0) {
            $query = " select * from trans_po a
        inner join m_supplier b on a.id_supplier = b.id_supplier
       
        inner join m_company e on a.id_company = e.id_company
        inner join jns_bayar f on a.jenis_bayar = f.id
        where a.tanggal  between '$startDate' and '$endDate'
        order by a.tanggal";
            $data['kota'] = 'ALL';
        } else {
            $query = " select * from trans_po a
        left join m_supplier b on a.id_supplier = b.id_supplier
        inner join m_company e on a.id_company = e.id_company
        inner join jns_bayar f on a.jenis_bayar = f.id
        where a.id_company = $id_company and a.tanggal  between '$startDate' and '$endDate' 
        order by a.tanggal";
            $data['dipilih'] = $this->db->get_where('m_company', ['id_company' => $id_company])->row_array();
            $data['kota'] = $data['dipilih']['nm_company'];
        }

        $data['konfirmasi'] = $this->db->query($query)->result_array();

        $querytbl = " select * from m_company";
        $data['tombol'] = $this->db->query($querytbl)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('info/v_rekap', $data);
        // $this->load->view('templates/footer');
    }
}
