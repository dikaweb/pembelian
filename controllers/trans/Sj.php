<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class sj extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("trans/sj_model");
    }


    public function index()
    {
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-90 days', strtotime($datenow)));
        $url = 'trans/sj/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Pengiriman ke gudang';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        if ($id_company == 0) {
            $query = " select *,nama_lengkap as name from trans_sj a
        left join m_penerima b on a.id_penerima = b.id_penerima
        left join user c on a.id_user = c.id
        inner join status d on a.status = d.id_status
        where a.tanggal  between '$startDate' and '$endDate' 
        order by a.tanggal";
            $data['kota'] = 'ALL';
        } else {
            $query = " select *,nama_lengkap as name from trans_sj a
        left join m_penerima b on a.id_penerima = b.id_penerima
        left join user c on a.id_user = c.id
        inner join status d on a.status = d.id_status
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
        $this->load->view('trans/v_sj', $data);
        // $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['title'] = 'Pengiriman ke gudang';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;
        $data['m_pengirim'] = $this->db->get('m_pengirim')->result_array();
        $data['m_penerima'] = $this->db->get('m_penerima')->result_array();
        $data['barang'] = $this->db->get('m_barang')->result_array();
        $data['m_company'] = $this->db->get('m_company')->result_array();
        $data['m_gudang'] = $this->db->query("select * from m_gudang where is_outstanding = 0 and is_kapasan = 0")->result_array();
        $data['m_satuan'] = $this->db->get('m_satuan')->result_array();


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_sj_add', $data);
    }

    public function edit($id_transaksi)
    {
        $data['title'] = 'Pengiriman ke gudang';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;

        $data['m_company'] = $this->db->get('m_company')->result_array();


        $data['m_satuan'] = $this->db->get('m_satuan')->result_array();
        $data['barang'] = $this->db->get('m_barang')->result_array();

        $data['pengirim'] = $this->db->query("select * from trans_sj a inner join m_penerima b on a.id_pengirim = b.id_penerima")->row_array();
        $data['konfirmasi_m'] = $this->sj_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->sj_model->konfirmasi_d($id_transaksi);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_sj_edit', $data);
    }

    public function save_m()
    {
        echo json_encode($this->sj_model->save_m());
    }

    public function save_d()
    {
        echo json_encode($this->sj_model->save_d());
    }

    /////////////////////////penerima
    public function save_penerima()
    {
        echo json_encode($this->sj_model->save_penerima());
    }
    public function update_penerima()
    {
        echo json_encode($this->sj_model->update_penerima());
    }
    public function delete_penerima()
    {
        echo json_encode($this->sj_model->delete_penerima());
    }

    /////////////////////////////barang
    public function save_barang()
    {
        echo json_encode($this->sj_model->save_barang());
    }
    public function update_barang()
    {
        echo json_encode($this->sj_model->update_barang());
    }
    public function delete_barang()
    {
        echo json_encode($this->sj_model->delete_barang());
    }

    /////////////////////end barang
    public function delete_m()
    {
        $post = $this->input->post();
        $nomor = $post["nomor"];
        $nama = $post["nama"];
        $dika = '<div class="alert alert-success" role="alert">No Transaksi ' . $nomor . ', Nama : ' . $nama . ' Berhasil di Hapus!</div>';
        $this->db->where('id_transaksi', $post['idd']);
        $this->db->delete('trans_sj_d');
        $this->db->where('id_transaksi', $post['idd']);
        $this->db->delete('trans_sj');
        $this->session->set_flashdata('messagez', $dika);
        redirect('trans/sj');
    }

    public function delete_d()
    {
        $post = $this->input->post();
        $this->db->where('id_detail', $post['idd']);
        $this->db->delete('trans_sj_d');
        $id_transaksi =  $post['idt'];
        $url = 'trans/sj/edit/' . $id_transaksi;
        redirect($url);
    }

    public function modal_view($id_transaksi)
    {
        $data['konfirmasi_m'] = $this->sj_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->sj_model->konfirmasi_d($id_transaksi);
        $this->load->view('trans/v_sj_modal_view', $data);
    }
    public function update_m()
    {
        $this->sj_model->update_m();

        $post = $this->input->post();
        $id_transaksi =  $post["txtid_transaksi"];
        $url = 'trans/sj/edit/' . $id_transaksi;
        redirect($url);
    }

    public function pilihbarang($id_gudang)
    {
        //ini dipakai
        $row = $this->db->get_where('m_gudang', ['id_gudang' => $id_gudang])->row_array();
        $id_company = $row['id_company'];
        $query = "SELECT * FROM trans_stock a 
        inner join m_satuan b on a.id_sat_terakhir = b.id_satuan 
        inner join m_barang c on a.id_barang = c.id_barang
        inner join m_gudang d on a.id_gudang = d.id_gudang
        where d.is_kapasan = 1 and  c.is_active=1 and d.id_company = $id_company and qty <> 0";
        $data['barang'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_sj_modal_barang', $data);
    }
    public function pilihpenerima()
    {
        $data['m_penerima'] = $this->db->get('m_penerima')->result_array();
        $data['jenis'] = 'penerima';
        $this->load->view('trans/v_sj_modal_penerima', $data);
    }
    public function pilihpengirim()
    {
        $data['m_penerima'] = $this->db->get('m_penerima')->result_array();
        $data['jenis'] = 'pengirim';
        $this->load->view('trans/v_sj_modal_penerima', $data);
    }

    public function cetak($id_transaksi)
    {

        $rowf = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_user = $rowf['id'];

        $query = "select id_detail from trans_sj_d where id_transaksi = $id_transaksi order by id_detail";
        $query = $this->db->query($query);
        $i = 1;
        foreach ($query->result() as $row) {
            $id_detail = $row->id_detail;
            $this->load->library('ciqrcode');
            $config['cacheable']    = true; //boolean, the default is true
            $config['cachedir']     = './assets/'; //string, the default is application/cache/
            $config['errorlog']     = './assets/'; //string, the default is application/logs/
            $config['imagedir']     = './assets/img/qrcode/'; //direktori penyimpanan qr code
            $config['quality']      = true; //boolean, the default is true
            $config['size']         = '1024'; //interger, the default is 1024
            $config['black']        = array(225, 255, 255); // array, default is array(255,255,255)
            $config['white']        = array(0, 0, 0); // array, default is array(0,0,0)
            $this->ciqrcode->initialize($config);
            $image_name = $id_user . '-' . $i .  '.png'; //buat name dari qr code sesuai dengan nim
            $params['data'] = $id_detail; //data yang akan di jadikan QR CODE
            $params['level'] = 'H'; //H=High
            $params['size'] = 10;
            $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
            $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            $i = $i + 1;
        }
        $url = 'trans/sj/cetak2/' . $id_transaksi;
        redirect($url);
    }
    public function cetak2($id_transaksi)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['master'] = $this->sj_model->cetak_m($id_transaksi);
        $data['detail'] = $this->sj_model->konfirmasi_d($id_transaksi);

        $query = "SELECT count(id_transaksi) as jml from trans_sj_d a
        inner join m_barang b on a.id_barang = b.id_barang 
        where a.id_transaksi = $id_transaksi  ";

        $data['xxx'] =  $this->db->query($query)->row_array();
        $this->load->view('cetak/c_sj', $data);
    }

    public function update_company_user()
    {
        $id_company = $this->input->post('id_company');
        $nm_company = $this->input->post('nm_company');
        $id_user = $this->input->post('id_user');
        $this->id_company = $id_company;
        $this->db->update("user", $this, array('id' => $id_user));
    }

    public function pilihgudang()
    {
        $id_gudang = $this->input->post('id_gudang');
        $row = $this->db->query("select id_company from m_gudang where id_gudang = $id_gudang")->row_array();
        echo json_encode($row['id_company']);
    }

    public function pilihpenawaran($jenis, $id_supplier, $id_company)
    {
        $query = "SELECT x.id_company,e.nm_company,x.id_penawaran,x.no_penawaran,a.id,b.id as id_d,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m
        ,item,qty,satuan,spesifikasi,b.keterangan as ket_d,catatan_purchasing
         FROM trans_penawaran x  
        inner join permintaan_barang a on x.id_pr = a.id
        inner join permintaan_barang_detail b on x.id_pr_d = b.id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        inner join m_company e on x.id_company = e.id_company
        where x.id_company = $id_company
        ";
        $data['barang'] = $this->db->query($query)->result_array();
        $data['jenis'] = $jenis;
        $this->load->view('trans/v_modal_penawaran', $data);
    }
}
