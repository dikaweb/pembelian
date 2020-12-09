<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Penawaran extends CI_Controller
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
        $dateawal = date('Y-m-d', strtotime('-45 days', strtotime($datenow)));
        $this->session->set_flashdata('messagex', $this->session->flashdata('messagey'));
        $this->session->set_flashdata('no_pr', $this->session->flashdata('no_pr'));
        $url = 'trans/penawaran/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Penawaran';
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

    public function edit_d($id_pr_d)
    {
        $data['title'] = 'Penawaran';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;
        $data['m_supplier'] = $this->db->get('m_supplier')->result_array();
        $data['m_company'] = $this->db->get('m_company')->result_array();

        $data['data_m'] = $this->penawaran_model->pr_detil_m($id_pr_d);
        $data['data_d'] = $this->penawaran_model->pr_detil_d($id_pr_d);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_penawaran_edit_detil', $data);
    }

    public function edit($id_transaksi)
    {
        $data['title'] = 'Penawaran';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;

        $data['m_company'] = $this->db->get('m_company')->result_array();


        $this->session->set_flashdata('messagey', $this->session->flashdata('messagez'));

        $data['data_m'] = $this->penawaran_model->data_m($id_transaksi);
        $data['data_d'] = $this->penawaran_model->data_d($id_transaksi);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_penawaran_add', $data);
    }

    public function save_m()
    {
        $post = $this->input->post();
        $id = $this->input->post('id_pr_d'); //array of id
        // var_dump($id);
        // die();

        $gbr["file_name"] = "";
        $is_sp = 0;
        $config['upload_path'] = "./assets/penawaran/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config, 'lokasi1');
        if ($this->lokasi1->do_upload("is_sp")) {
            $gbr = $this->lokasi1->data();
            //Compress Image
            $configsize['image_library'] = 'gd2';
            $configsize['source_image'] = './assets/penawaran/' . $gbr['file_name'];
            $configsize['create_thumb'] = FALSE;
            $configsize['maintain_ratio'] = TRUE;
            $configsize['height'] = 700;
            $configsize['new_image'] = './assets/penawaran/' . $gbr['file_name'];
            $this->load->library('image_lib', $configsize);
            $this->image_lib->resize();
            $is_sp = 1;
            $id_user = $this->session->userdata('id_loginz');
            $data2 = [
                'id_supplier' => $post['txtid_rekanan1'],
                'top' => $post['top'],
                'id_user' => $id_user,
                'nm_file' => $gbr["file_name"]
            ];
            $this->db->insert('gbr_penawaran', $data2);
            $row = $this->db->query('select max(id_penawaran) as id_penawaran from gbr_penawaran')->row_array();
            $id_penawaran = $row['id_penawaran'];
        }

        $updateArray = array();
        for ($x = 0; $x < sizeof($id); $x++) {
            //for ($x = 0; $x < 27; $x++) {

            $updateArray[] = array(
                'id_pr_d' => $id[$x],
                'id_penawaran' => $id_penawaran,
                'id_user' => $id_user,
            );
        }
        $this->db->insert_batch('permintaan_barang_penawaran', $updateArray);

        $this->session->set_flashdata('no_pr', $post['no_pr']);
        return  1;
    }

    public function save_detil_d()
    {
        //$this->penawaran_model->update_m();
        echo json_encode($this->penawaran_model->save_detil_d());
    }

    /////////////////////////supplier
    public function save_supplier()
    {
        echo json_encode($this->penawaran_model->save_supplier());
    }
    public function update_supplier()
    {
        echo json_encode($this->penawaran_model->update_supplier());
    }
    public function delete_supplier()
    {
        echo json_encode($this->penawaran_model->delete_supplier());
    }



    public function delete_d()
    {
        $post = $this->input->post();
        $this->db->where('id', $post['idhd']);
        $this->db->delete('permintaan_barang_penawaran');
        $id_transaksi =  $post['idhm'];
        $url = 'trans/penawaran/edit_d/' . $id_transaksi;
        redirect($url);
    }

    public function modal_view($id_transaksi)
    {
        $data['data_m'] = $this->penawaran_model->data_m($id_transaksi);
        $data['data_d'] = $this->penawaran_model->data_d($id_transaksi);
        $this->load->view('trans/v_penawaran_modal_view', $data);
    }
    public function update_m()
    {
        $this->penawaran_model->update_m();
        $this->session->set_flashdata('messagez', 'Data berhasil disimpan');
        $post = $this->input->post();
        $id_transaksi =  $post["id_penawaran"];
        $url = 'trans/penawaran/edit/' . $id_transaksi;
        redirect($url);
    }

    public function pilihsupplier()
    {
        $data['m_supplier'] = $this->db->get('m_supplier')->result_array();
        $this->load->view('trans/v_penawaran_modal_supplier', $data);
    }




    public function detilarea($id)
    {
        $query = "SELECT * from permintaan_barang_detail a where a.permintaan_barang_id = $id
        ";
        $data['detil'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_ajax_detilarea', $data);
    }
    public function gbr_penawaran($id)
    {
        $query = "SELECT *,a.id as id_hapus from permintaan_barang_penawaran a 
        inner join permintaan_barang_detail b on a.id_pr_d = b.id
        inner join gbr_penawaran c on c.id_penawaran = a.id_penawaran
        inner join m_supplier d on c.id_supplier = d.id_supplier
        where a.id_pr_d = $id
        ";
        $data['detil'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_penawaran_modal_gbr', $data);
    }
    public function gbr_penawaran_d($id_penawaran)
    {
        $query = "SELECT *  from gbr_penawaran a
        inner join m_supplier b on a.id_supplier = b.id_supplier
        where a.id_penawaran = $id_penawaran
        ";
        $data['detil'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_penawaran_modal_gbr', $data);
    }

    public function list_detil()
    {
        $id = $this->input->post('id');
        $query = "SELECT *,a.id,(select count(*) from permintaan_barang_penawaran where id_pr_d = a.id) as jml_penawaran
        ,a.keterangan, IF(a.is_po=1,'Ya','Belum') as is_pospk
        from permintaan_barang_detail a 
        inner join permintaan_barang b on a.permintaan_barang_id = b.id
        where a.permintaan_barang_id = $id
        ";
        $data = $this->db->query($query)->result_array();
        echo json_encode($data);
    }
}
