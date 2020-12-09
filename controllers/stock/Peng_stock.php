<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Peng_stock extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("stock/peng_stock_model");
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_company = $row['id_company'];
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-90 days', strtotime($datenow)));
        $url = 'stock/peng_stock/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Pengeluaran Stock';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();


        $query = " select * from trans_pengeluaran a 
            inner join user b on a.id_user = b.id
            where a.tanggal  between '$startDate' and '$endDate' 
            order by a.tanggal 
            ";

        $data['konfirmasi'] = $this->db->query($query)->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('stock/v_peng_stock', $data);
        // $this->load->view('templates/footer');
    }

    public function add()
    {
        //var_dump(date('d-m-y'));
        $data['title'] = 'Pengeluaran Stock';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('stock/v_peng_stock_add', $data);
    }

    public function edit($id_transaksi)
    {
        $data['title'] = 'Pengeluaran Stock';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;


        $data['m_satuan'] = $this->db->get('m_satuan')->result_array();
        $data['barang'] = $this->db->get('m_barang')->result_array();

        $data['konfirmasi_m'] = $this->peng_stock_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->peng_stock_model->konfirmasi_d($id_transaksi);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('stock/v_peng_stock_edit', $data);
    }

    public function save_m()
    {
        echo json_encode($this->peng_stock_model->save_m());
    }

    public function save_d()
    {
        echo json_encode($this->peng_stock_model->save_d());
    }


    /////////////////////end barang
    public function delete_m()
    {
        $post = $this->input->post();
        $nomor = $post["nomor"];
        $nama = $post["nama"];
        $dika = '<div class="alert alert-success" role="alert">No Transaksi ' . $nomor . ', Nama : ' . $nama . ' Berhasil di Hapus!</div>';
        $this->db->where('id_pengeluaran', $post['idd']);
        $this->db->delete('trans_pengeluaran_d');
        $this->db->where('id_pengeluaran', $post['idd']);
        $this->db->delete('trans_pengeluaran');
        $this->session->set_flashdata('messagez', $dika);
        redirect('stock/peng_stock');
    }

    public function delete_d()
    {
        $post = $this->input->post();
        $this->db->where('id_pengeluaran_d', $post['idd']);
        $this->db->delete('trans_pengeluaran_d');
        $id_transaksi =  $post['idt'];
        $url = 'stock/peng_stock/edit/' . $id_transaksi;
        redirect($url);
    }


    public function update_m()
    {
        $this->peng_stock_model->update_m();
        $this->session->set_flashdata('messagez', 'Data berhasil disimpan');
        $post = $this->input->post();
        $id_transaksi =  $post["txtid_transaksi"];
        $url = 'trans/po/edit/' . $id_transaksi;
        redirect($url);
    }


    public function pilihbarang($id_gudang)
    {
        //ini dipakai
        $query = "SELECT * FROM peng_stock a 
        inner join m_satuan b on a.id_sat_terakhir = b.id_satuan 
        inner join m_barang c on a.id_barang = c.id_barang
        inner join m_gudang d on a.id_gudang = d.id_gudang
        where a.id_gudang  = $id_gudang";
        $data['barang'] = $this->db->query($query)->result_array();
        $this->load->view('stock/v_peng_stock_modal_barang', $data);
    }
    public function pilihgudang($jenis)
    {
        $data['m_gudang'] = $this->db->query('select * from m_gudang a inner join m_company b on a.id_company = b.id_company where a.is_kapasan = 1')->result_array();
        $data['jenis'] = $jenis;
        $this->load->view('stock/v_peng_stock_modal_gudang', $data);
    }
}
