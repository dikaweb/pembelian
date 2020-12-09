<?php
defined('BASEPATH') or exit('No direct script access allowed');

class app_po extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("trans/po_model");
    }


    public function index()
    {
        $data['title'] = 'Pending Approval';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        //$v_all = $this->session->flashdata('v_allz'); //session ini diambil dari helper 

        $awal = $data['user']['awal'];
        $akhir = $data['user']['akhir'];
        //inner join permintaan_barang b on a.id_pr = b.id
        //inner join permintaan_barang_detail f on a.id_pr_d = f.id
        //inner join user g on b.user_id = g.id
        $query = " select a.id_transaksi,no_transaksi,tanggal,nm_supplier,nm_company,nama_lengkap as name,a.jenis 
        ,(sum(f.jumlah*f.harga) * (nilai_pph/100)) + sum(f.jumlah*f.harga) as tt
        from trans_po a
        inner join m_supplier b on a.id_supplier = b.id_supplier
        inner join user c on a.id_user = c.id
        inner join status d on a.status = d.id_status
        inner join m_company e on a.id_company = e.id_company
        left join trans_po_d f on a.id_transaksi = f.id_transaksi
        where a.status = 2
        group by a.id_transaksi,no_transaksi,tanggal,nm_supplier,nm_company,nama_lengkap,a.jenis
        having tt between $awal and $akhir
        ";
        $data['konfirmasi'] = $this->db->query($query)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('approve/v_app_po', $data);
    }



    public function approve_po()
    {
        $my_date = date("Y-m-d H:i:s");
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $post = $this->input->post();
        $id = $post['id_transaksi'];
        $data2 = [
            'status' => 2
        ];
        $this->db->update('trans_po_d', $data2, array('id_transaksi' =>  $id));
        $data = [
            'id_approve_po' => $data['user']['id'],
            'date_approve_po' => $my_date,
            'status' => 3,
        ];
        $this->db->update('trans_po', $data, array('id_transaksi' =>  $id));

        echo json_encode(1);
    }

    public function modal_approve_po($id_transaksi)
    {
        $data['data_m'] = $this->po_model->konfirmasi_m($id_transaksi);
        $data['data_d'] = $this->po_model->konfirmasi_d($id_transaksi);
        $data['judul'] = "Data PO";
        $this->load->view('approve/v_app_po_modal', $data);
    }
    public function modal_approve_spk($id_transaksi)
    {
        $data['data_m'] = $this->po_model->konfirmasi_m($id_transaksi);
        $data['data_d'] = $this->po_model->konfirmasi_d($id_transaksi);
        $data['judul'] = "Data SPK";
        $this->load->view('approve/v_app_po_modal', $data);
    }

    public function void_po()
    {
        $my_date = date("Y-m-d H:i:s");
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $post = $this->input->post();
        $id = $post['id_transaksi'];

        $data = [
            'id_approve_po' => $data['user']['id'],
            'date_approve_po' => $my_date,
            'note_void' => $post['txtnote_void'],
            'status' => 9,
        ];
        $this->db->update('trans_po', $data, array('id_transaksi' =>  $id));
        $data2 = [
            'status' => 9
        ];
        $this->db->update('trans_po_d', $data2, array('id_transaksi' =>  $id));


        redirect('approve/app_po');
    }
}
