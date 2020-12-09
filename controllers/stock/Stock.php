<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class stock extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
        //$this->load->model("trans/bpb_model");
    }


    public function index()
    {
        $url = 'stock/stock/view/0';
        redirect($url);
    }


    public function view($id_gudang)
    {
        $data['title'] = 'Stock';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        if ($id_gudang == 0) {
            $query = " select * from trans_stock a
            inner join m_gudang b on a.id_gudang = b.id_gudang
            inner join m_satuan c on a.id_sat_terakhir = c.id_satuan
            inner join m_barang d on a.id_barang = d.id_barang
            inner join m_company e on b.id_company = e.id_company
            where qty <> 0
            ";
            $data['kota'] = 'ALL';
        } else {
            $query = "select * from trans_stock a
            inner join m_gudang b on a.id_gudang = b.id_gudang
            inner join m_satuan c on a.id_sat_terakhir = c.id_satuan
            inner join m_barang d on a.id_barang = d.id_barang
            inner join m_company e on b.id_company = e.id_company
            where a.id_gudang = $id_gudang";
            $data['dipilih'] = $this->db->get_where('m_gudang', ['id_gudang' => $id_gudang])->row_array();
            $data['kota'] = $data['dipilih']['kd_gudang'];
        }
        $data['konfirmasi'] = $this->db->query($query)->result_array();
        $querytbl = " select * from m_gudang";
        $data['tombol'] = $this->db->query($querytbl)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('stock/v_stock', $data);
        // $this->load->view('templates/footer');
    }

    public function modal_view($id_barang, $id_gudang)
    {
        $r_gd = $this->db->get_where('m_gudang', ['id_gudang' => $id_gudang])->row_array();
        if ($r_gd['is_outstanding'] == 1) {
            $query = "
        select b.no_transaksi as no_trans, a.date_created as date_d, jumlah as jml_t from trans_po_d a
                inner join trans_po b on a.id_transaksi = b.id_transaksi
                where id_barang = $id_barang and id_gudang = $id_gudang
                
        union all
        select c.no_bpb as no_trans,a.date_created as date_d,a.jumlah * -1 as jml_t from trans_bpb_d a
                inner join trans_po_d b on b.id_detail = a.id_po_d
                inner join trans_bpb c on a.id_bpb = c.id_bpb
                where b.id_barang = $id_barang and b.id_gudang = $id_gudang
        ";
        } else {
            $query = "
            select c.no_bpb as no_trans,a.date_created as date_d,a.jumlah as jml_t from trans_bpb_d a
                    inner join trans_bpb c on a.id_bpb = c.id_bpb
                    where a.id_barang = $id_barang and a.id_gudang = $id_gudang
            
            union all
            select b.no_transaksi as no_trans, a.date_created as date_d,a.jumlah * -1 as jml_t from trans_sj_d a
                    inner join trans_sj b on a.id_transaksi = b.id_transaksi
                    where a.id_barang = $id_barang and a.id_gudang_from = $id_gudang
            
            union all
            select b.no_transaksi as no_trans, a.date_created as date_d,a.jumlah as jml_t from trans_sj_d a
                    inner join trans_sj b on a.id_transaksi = b.id_transaksi
                    where a.id_barang = $id_barang and a.id_gudang_to = $id_gudang
            
            union all
            select b.no_transfer_stock as no_trans, a.date_created as date_d,a.jumlah * -1 as jml_t from transfer_stock_d a
                    inner join transfer_stock b on a.id_transfer_stock = b.id_transfer_stock
                    where a.id_barang = $id_barang and a.id_gudang_from = $id_gudang
                    
            union all
            select b.no_transfer_stock as no_trans, a.date_created as date_d,a.jumlah as jml_t from transfer_stock_d a
                    inner join transfer_stock b on a.id_transfer_stock = b.id_transfer_stock
                    where a.id_barang = $id_barang and a.id_gudang_to = $id_gudang
            
            union all
            select b.no_input_stock as no_trans, a.date_created as date_d,a.jumlah as jml_t from trans_input_stock_d a
                    inner join trans_input_stock b on a.id_input_stock = b.id_input_stock
                    where a.id_barang = $id_barang and a.id_gudang_from = $id_gudang

            union all
            select b.no_pengeluaran as no_trans, a.date_created as date_d,a.jumlah * -1 as jml_t from trans_pengeluaran_d a
                    inner join trans_pengeluaran b on a.id_pengeluaran = b.id_pengeluaran
                    where a.id_barang = $id_barang and a.id_gudang_from = $id_gudang
            
            union all
            select jenis as no_trans, date_created as date_d,jml_konv_terkecil * -1 as jml_t from trans_pengeluaran_del
                    where id_barang = $id_barang and id_gudang_from = $id_gudang and is_plus = 0
            
            union all
            select jenis as no_trans, date_created as date_d,jml_konv_terkecil as jml_t from trans_pengeluaran_del
                    where id_barang = $id_barang and id_gudang_from = $id_gudang and is_plus = 1
            
            union all
            select jenis as no_trans, date_created as date_d,jml_konv_terkecil * -1 as jml_t from trans_input_stock_del
                    where id_barang = $id_barang and id_gudang_from = $id_gudang and is_plus = 0
            
            union all
            select jenis as no_trans, date_created as date_d,jml_konv_terkecil as jml_t from trans_input_stock_del
                    where id_barang = $id_barang and id_gudang_from = $id_gudang and is_plus = 1
            
            union all
            select jenis as no_trans, date_created as date_d,jml_konv_terkecil * -1 as jml_t from transfer_stock_del
                    where id_barang = $id_barang and id_gudang_from = $id_gudang and is_plus = 0
            
            union all
            select jenis as no_trans, date_created as date_d,jml_konv_terkecil as jml_t from transfer_stock_del
                    where id_barang = $id_barang and id_gudang_from = $id_gudang and is_plus = 1

            ";
        }
        $data['konfirmasi'] = $this->db->query($query)->result_array();
        $this->load->view('stock/v_stock_modal_view', $data);
    }
}
