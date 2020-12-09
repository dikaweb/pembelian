<?php
defined('BASEPATH') or exit('No direct script access allowed');

class bpb_model extends CI_Model
{
    // public function save_m()
    // {
    //     //gak di pakai
    //     $id_po_d = $post['id_po_d'];
    //     $id_barang = $post['id_barang'];
    //     $id_satuan = $post['id_satuan'];
    //     $jumlah = $post['jumlah'];

    //     // update dulu po_d ke satuan terkecil
    //     $rt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
    //     $id_sat_terkecil = $rt['id_satuan'];
    //     $this->db->query("update trans_po_d set jml_konv_terkecil = konversi_satuan($id_barang,id_sat_konv_terakhir) * jml_konv_terkecil,id_sat_konv_terakhir = $id_sat_terkecil where id_detail = $id_po_d");
    //     //cek nilai yang diinputkan dg po_d terkecil
    //     $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
    //     $hasil = $konv['hasil'];
    //     $row = $this->db->query("select * from trans_po_d where id_detail = $id_po_d")->row_array();
    //     $sisa_po = $row['jml_konv_terkecil'] - $row['jml_dt_konv_terkecil'];

    //     $akhir = $sisa_po - $hasil;
    //     if ($akhir >= 0) {
    //         $data2 = [
    //             'id_transaksi' => $id_transaksi,
    //             'id_barang' => $post['id_barang'],
    //             'id_satuan' => $post['id_satuan'],
    //             'id_gudang' => $post['id_gudang'],
    //             'nm_barang' => $post['nm_barang'],
    //             'id_po_d' => $post['id_po_d'],
    //             'jumlah' => $post['jumlah']
    //         ];
    //         $this->db->insert('trans_bpb_d', $data2);
    //     } else {
    //         $dika = '<div class="alert alert-danger" role="alert">Jumlah ' . $jumlah . ', Nilai Konversi terkecil: ' . $hasil .  ', Sisa PO : ' . $sisa_po . '. <br> Gagal disimpan, Jumlah melebihi dari PO <br> Ulangi Input Barang !!!</div>';
    //         $this->session->set_flashdata('messagez', $dika);
    //     }


    //     return  $id_transaksi;
    // }

    public function save_d()
    {
        $post = $this->input->post();
        $id_po_d = $post['id_po_d'];
        $id_barang = $post['id_barang'];
        $id_satuan = $post['id_satuan'];
        $jumlah = $post['jumlah'];
        // update dulu po_d ke satuan terkecil
        $rt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
        $id_sat_terkecil = $rt['id_satuan'];
        $this->db->query("update trans_po_d set jml_konv_terkecil = konversi_satuan($id_barang,id_sat_konv_terakhir) * jml_konv_terkecil,id_sat_konv_terakhir = $id_sat_terkecil where id_detail = $id_po_d");
        $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
        $hasil = $konv['hasil'];
        $row = $this->db->query("select * from trans_po_d where id_detail = $id_po_d")->row_array();
        $sisa_po = $row['jml_konv_terkecil'] - $row['jml_dt_konv_terkecil'];
        $jenis = $row['jenis'];
        $akhir = $sisa_po - $hasil;

        if ($akhir >= 0) {
            $data = [
                'id_bpb' => $post['id_transaksi'],
                'id_barang' => $post['id_barang'],
                'id_satuan' => $post['id_satuan'],
                'id_gudang' => $post['id_gudang'],
                'id_po_d' => $post['id_po_d'],
                'jumlah' => $post['jumlah'],
                'jenis' => $jenis,
                'nm_barang' => $post['nm_barang'],
                'harga' => $post['harga'],
                'total' => (float)$post['harga'] * (float)$post['jumlah'],

            ];
            $this->db->insert('trans_bpb_d', $data);
        } else {
            $dika = '<div class="alert alert-danger" role="alert">Jumlah ' . $jumlah . ', Nilai Konversi terkecil: ' . $hasil .  ', Sisa PO : ' . $sisa_po . '. <br> Gagal disimpan, Jumlah melebihi dari PO<br> Ulangi Input Barang !!!</div>';
            $this->session->set_flashdata('messagez', $dika);
        }
        return $post['id_transaksi'];
    }

    public function konfirmasi_m($id_transaksi)
    {

        $query = "SELECT  a.id_bpb as id_transaksi, a.tanggal as tanggal, a.no_bpb as no_transaksi, a.id_po_spk as id_po,
        b.nm_supplier as nm_supplier, b.id_supplier as id_supplier, b.alamat_sp as alamat_sp,
        a.id_company,c.no_transaksi as no_po_spk,c.tanggal as tgl_po_spk,a.id_gudang,e.kd_gudang,a.id_user
        from trans_bpb a 
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join trans_po c on a.id_po_spk = c.id_transaksi
        inner join m_company d on a.id_company = d.id_company
        inner join m_gudang e on a.id_gudang = e.id_gudang
        where a.id_bpb = $id_transaksi
        ";

        return $this->db->query($query)->row_array();
    }

    public function cetak_m($id_transaksi)
    {

        $query = "SELECT * from trans_bpb a 
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join trans_po c on a.id_po_spk = c.id_transaksi
        inner join m_company d on a.id_company = d.id_company
        inner join m_gudang e on a.id_gudang = e.id_gudang
        inner join user f on a.id_user = f.id
        where a.id_bpb = $id_transaksi
        ";

        return $this->db->query($query)->row_array();
    }
    public function gbr($id_transaksi)
    {

        $query = "SELECT  * from trans_bpb_d_gbr 
        where id_bpb = $id_transaksi
        ";

        return $this->db->query($query)->result_array();
    }

    // public function add_m($id_po_spk, $jenis)
    // {
    //     if ($jenis == 'PO') {
    //         $query = "SELECT  a.id_transaksi as id_transaksi, a.tanggal as tgl_po_spk, a.no_transaksi as no_transaksi,
    //     b.nm_supplier as nm_supplier, b.id_supplier as id_supplier, b.alamat_sp as alamat_sp,
    //     a.id_company
    //     from trans_po a 
    //     inner join m_supplier b on a.id_supplier = b.id_supplier
    //     inner join m_company d on a.id_company = d.id_company
    //     where a.id_transaksi = $id_po_spk
    //     ";
    //     } else {
    //         $query = "SELECT  a.id_bpb as id_transaksi, a.tanggal as tanggal, a.no_bpb as no_transaksi, a.id_po_spk as id_po,
    //     b.nm_supplier as nm_supplier, b.id_supplier as id_supplier, b.alamat_sp as alamat_sp,
    //     a.id_company,c.no_spk as no_po_spk,c.tanggal as tgl_po_spk
    //     from trans_bpb a 
    //     left join m_supplier b on a.id_supplier = b.id_supplier
    //     left join trans_spk c on a.id_po_spk = c.id_spk
    //     inner join m_company d on a.id_company = d.id_company
    //     where a.id_bpb = $id_transaksi
    //     ";
    //     }
    //     return $this->db->query($query)->row_array();
    // }

    public function add_d($id_po_spk)
    {
        $query = "SELECT * from trans_po_d a 
            inner join m_barang b on a.id_barang = b.id_barang
            left join m_satuan c on a.id_satuan = c.id_satuan
            inner join m_gudang d on a.id_gudang = d.id_gudang
            where a.id_transaksi = $id_po_spk 
            and ((jml_dt_konv_terkecil < jml_konv_terkecil) or (jml_dt_konv_terkecil = 0 and jml_konv_terkecil = 0))
            order by id_detail
            ";
        return $this->db->query($query)->result_array();
    }

    public function konfirmasi_d($id_transaksi)
    {
        $query = "SELECT * from trans_bpb_d a 
        inner join m_barang b on a.id_barang = b.id_barang
        left join m_satuan c on a.id_satuan = c.id_satuan
        inner join m_gudang d on a.id_gudang = d.id_gudang
        where a.id_bpb = $id_transaksi order by id_detail
        ";
        return $this->db->query($query)->result_array();
    }

    public function upload()
    {
        $post = $this->input->post();
        $id_bpb =  $post['txtid_transaksi'];
        //$id_pr_d =  $post['top'];
        //$gbr["file_name"] = "";
        $config['upload_path'] = "./assets/bpb/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config, 'lokasi1');
        if ($this->lokasi1->do_upload("is_sp")) {
            $gbr = $this->lokasi1->data();
            //Compress Image
            $configsize['image_library'] = 'gd2';
            $configsize['source_image'] = './assets/bpb/' . $gbr['file_name'];
            $configsize['create_thumb'] = FALSE;
            $configsize['maintain_ratio'] = TRUE;
            $configsize['height'] = 700;
            $configsize['new_image'] = './assets/bpb/' . $gbr['file_name'];
            $this->load->library('image_lib', $configsize);
            $this->image_lib->resize();

            $id_user = $this->session->userdata('id_loginz');
            $data2 = [
                'id_bpb' => $id_bpb,
                'jenis' => $post['txtjenis'],
                'id_user' => $id_user,
                'nm_file' => $gbr["file_name"],
                'ket' => $post['txtket'],
            ];
            $this->db->insert('trans_bpb_d_gbr', $data2);
        }

        return  (int)$id_bpb;
    }
    public function upload_m($id_transaksi)
    {
        $post = $this->input->post();
        $id_bpb =  $id_transaksi;
        //$id_pr_d =  $post['top'];
        //$gbr["file_name"] = "";
        $config['upload_path'] = "./assets/bpb/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config, 'lokasi1');
        if ($this->lokasi1->do_upload("is_sp")) {
            $gbr = $this->lokasi1->data();
            //Compress Image
            $configsize['image_library'] = 'gd2';
            $configsize['source_image'] = './assets/bpb/' . $gbr['file_name'];
            $configsize['create_thumb'] = FALSE;
            $configsize['maintain_ratio'] = TRUE;
            $configsize['height'] = 700;
            $configsize['new_image'] = './assets/bpb/' . $gbr['file_name'];
            $this->load->library('image_lib', $configsize);
            $this->image_lib->resize();

            $id_user = $this->session->userdata('id_loginz');
            $data2 = [
                'id_bpb' => $id_bpb,
                'jenis' => $post['txtjenis'],
                'id_user' => $id_user,
                'nm_file' => $gbr["file_name"],
                'ket' => $post['txtket'],
            ];
            $this->db->insert('trans_bpb_d_gbr', $data2);
        }
    }
}
