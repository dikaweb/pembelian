<?php
defined('BASEPATH') or exit('No direct script access allowed');

class price_app extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        // $this->load->model("trans/bpb_model");
    }


    public function index()
    {
        $data['title'] = 'Price Changes App';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        //$v_all = $this->session->flashdata('v_allz'); //session ini diambil dari helper 
        $query = " select * from trans_bpb a 
        inner join m_supplier b on a.id_supplier = b.id_supplier
        where is_harga_tambah = 1";
        $data['konfirmasi'] = $this->db->query($query)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('approve/v_price_app', $data);
    }

    public function modal_price_app($id_transaksi)
    {
        $data['data_m'] = $this->db->query(" select * from trans_bpb a 
        inner join m_supplier b on a.id_supplier = b.id_supplier
        inner join m_company c on a.id_company = c.id_company
        inner join stat_ppn d on a.id_ppn_pph = d.id_ppn_pph
        where id_bpb = $id_transaksi")->row_array();
        $data['data_d'] = $this->db->query(" SELECT a.nm_barang, b.harga as hrg_po, a.harga as hrg_bpb 
        from trans_bpb_d a 
        inner join trans_po_d b on b.id_detail = a.id_po_d
        where a.id_bpb = $id_transaksi and a.harga>b.harga order by a.id_detail")->result_array();
        $data['judul'] = "Data PO";
        $this->load->view('approve/v_price_app_modal', $data);
    }

    public function app_price()
    {
        $post = $this->input->post();
        $id = $post['id_transaksi'];

        $data = [
            'is_harga_tambah' => 0,
        ];
        $this->db->update('trans_bpb', $data, array('id_bpb' =>  $id));

        redirect('approve/price_app');
    }
}
