<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Po_progress extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("trans/po_model");
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_company = $row['id_company'];
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-90 days', strtotime($datenow)));
        $url = 'info/po_progress/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'PO/SPK Progress';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        if ($id_company == 0) {
            $query = " select *,nama_lengkap as name from trans_po a
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join user c on a.id_user = c.id
        inner join m_company e on a.id_company = e.id_company
        inner join jns_bayar f on a.jenis_bayar = f.id
        where a.tanggal  between '$startDate' and '$endDate' and (a.is_voucher <> 1 or a.status <> 5)
        order by a.tanggal";
            $data['kota'] = 'ALL';
        } else {
            $query = " select *,nama_lengkap as name from trans_po a
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join user c on a.id_user = c.id
        inner join m_company e on a.id_company = e.id_company
        inner join jns_bayar f on a.jenis_bayar = f.id
        where a.id_company = $id_company and a.tanggal  between '$startDate' and '$endDate' and a.is_voucher <> 1 and a.status <> 5
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
        $this->load->view('trans/v_po', $data);
        // $this->load->view('templates/footer');
    }
}
