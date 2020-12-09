<?php
defined('BASEPATH') or exit('No direct script access allowed');

class penawaran_model extends CI_Model
{

    public function update_m()
    {
        $post = $this->input->post();
        $data = [
            'id_pr' => $post['txtIdPr'],
            'id_pr_d' => $post['txtIdPr_d'],
            'id_company' => $post['txt_company']
        ];
        $this->db->update('gbr_penawaran', $data, array('id_penawaran' =>  $post["id_penawaran"]));
    }

    public function save_detil_d()
    {
        $post = $this->input->post();
        $id_pr_d =  $post['txtIdPr_d'];
        //$id_pr_d =  $post['top'];
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
            $data3 = [
                'id_pr_d' => $id_pr_d,
                'id_penawaran' => $id_penawaran,
                'id_user' => $id_user,
            ];
            $this->db->insert('permintaan_barang_penawaran', $data3);
        }

        return  (int)$id_pr_d;
    }
    //////////////////////////////supplier
    public function save_supplier()
    {
        $post = $this->input->post();
        $data = [
            'nm_supplier' => $post['nm_supplier'],
            'alamat_sp' => $post['alamat_sp'],
            'up_sp' => $post['up_sp'],
            'no_rek' => $post['no_rek'],
        ];
        $this->db->insert('m_supplier', $data);
    }

    public function update_supplier()
    {
        $post = $this->input->post();
        $id = $post["id_supplier"];
        $row = $this->db->query("select count(id_supplier) as ct from gbr_penawaran where id_supplier = $id")->row_array();
        if ($row['ct'] == 0) {
            $data = [
                'nm_supplier' => $post['nm_supplier'],
                'alamat_sp' => $post['alamat_sp'],
                'up_sp' => $post['up_sp'],
                'no_rek' => $post['no_rek'],
            ];
            $this->db->update('m_supplier', $data, array('id_supplier' =>  $post["id_supplier"]));
        }
        return $row['ct'];
    }
    public function delete_supplier()
    {
        $post = $this->input->post();
        $id = $post["id_supplier"];
        $row = $this->db->query("select count(id_supplier) as ct from gbr_penawaran where id_supplier = $id")->row_array();
        if ($row['ct'] == 0) {
            $this->db->where('id_supplier', $post['id_supplier']);
            $this->db->delete('m_supplier');
        }
        return $row['ct'];
    }
    /////////////////////////////////barang
    public function save_barang()
    {
        $post = $this->input->post();
        $data = [
            'nm_barang' => $post['nm_barang'],
            'satuan' => $post['satuan'],
            'is_active' => 1,
        ];
        $this->db->insert('m_barang', $data);
    }

    public function update_barang()
    {
        $post = $this->input->post();
        $id = $post["id_barang"];
        $row = $this->db->query("select count(id_barang) as ct from trans_po_d where id_barang = $id")->row_array();
        if ($row['ct'] == 0) {
            $data = [
                'nm_barang' => $post['nm_barang'],
                'satuan' => $post['satuan'],
            ];
            $this->db->update('m_barang', $data, array('id_barang' =>  $post["id_barang"]));
        }
        return $row['ct'];
    }
    public function delete_barang()
    {
        $post = $this->input->post();
        $id = $post["id_barang"];
        $row = $this->db->query("select count(id_barang) as ct from trans_po_d where id_barang = $id")->row_array();
        if ($row['ct'] == 0) {
            $this->db->where('id_barang', $post['id_barang']);
            $this->db->delete('m_barang');
        }
        return $row['ct'];
    }
    ////////////////end barang
    public function data_m($id_transaksi)
    {
        $query = "select *,SUBSTRING(b.date_time,1,10) as tgl,b.keterangan as ket_m,b.id
        from permintaan_barang b 
        inner join user d on b.user_id = d.id
        left join m_company e on b.id_company = e.id_company
        where b.id = $id_transaksi
        ";
        return $this->db->query($query)->row_array();
    }

    public function data_d($id_transaksi)
    {
        $query = "SELECT * from permintaan_barang_detail
        where permintaan_barang_id = $id_transaksi 
        ";
        return $this->db->query($query)->result_array();
    }

    public function pr_detil_m($id_pr_d)
    {
        $query = "SELECT *,a.id as id_pr_d, b.id as id_pr,SUBSTRING(b.date_time,1,10) as tgl,b.keterangan as ket_m,a.keterangan as ket_d
         from permintaan_barang_detail a 
        inner join permintaan_barang b on a.permintaan_barang_id = b.id
        left join m_company c on b.id_company = c.id_company
        left join m_nopol d on b.id_nopol = d.id_nopol
        inner join user e on b.user_id = e.id
        where a.id = $id_pr_d
        ";
        return $this->db->query($query)->row_array();
    }

    public function pr_detil_d($id_pr_d)
    {
        $query = "SELECT *,a.id as id_hapus from permintaan_barang_penawaran a 
        inner join permintaan_barang_detail b on a.id_pr_d = b.id
        inner join gbr_penawaran c on c.id_penawaran = a.id_penawaran
        inner join m_supplier d on c.id_supplier = d.id_supplier
        where a.id_pr_d = $id_pr_d
        ";
        return $this->db->query($query)->result_array();
    }
}
