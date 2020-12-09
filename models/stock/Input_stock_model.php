<?php
defined('BASEPATH') or exit('No direct script access allowed');

class input_stock_model extends CI_Model
{
    public function save_m()
    {

        $post = $this->input->post();
        $tahun = date('Y');


        $tgl_upload = date("Y-m-d");
        $tahun = date('Y', strtotime($tgl_upload));
        //$id_company = 1;

        $query1 = $this->db->query("select no_urut as max_id from trans_input_stock where no_urut = (SELECT MAX(no_urut) FROM trans_input_stock)");
        $row = $query1->row_array();

        if (isset($row['max_id'])) {
            $no_urut = $row['max_id'] + 1;

            $mulai = $row['max_id'] - 1;
            $query2 = $this->db->query("select no_urut from trans_input_stock where no_urut > $mulai order by no_urut");
            $arr1 =  $query2->result_array();
            $n = count($arr1);
            if ($n != 0) {
                $p = 0;
                foreach ($arr1 as $row) {
                    $arr2[$p] =  (int) $row['no_urut'];
                    $p++;
                }
                $xx = findMissing($arr2, $n);

                if ($xx != 0) {
                    $no_urut = $xx;
                }
            } else {
                $no_urut = 1;
            }
        } else {
            $no_urut = 1;
        }
        $no_po = "INPSTOCK-"  . sprintf("%04s", $no_urut);
        $data = [
            //'no_transaksi' => $post['no_transaksi'],
            'no_input_stock' => $no_po,
            'no_urut' => $no_urut,
            'tanggal' =>  date("Y-m-d"),
            'id_user' => $post['id_user'],
            'note' => $post['note'],
            'tahun' => $tahun
        ];
        $this->db->insert('trans_input_stock', $data);


        $row = $this->db->query('select max(id_input_stock) as id_transaksi from trans_input_stock ')->row_array();
        $id_transaksi = $row['id_transaksi'];
        $id_barang = $post['id_barang'];
        $jumlah = $post['jumlah'];
        $id_satuan = $post['id_satuan'];
        $tt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
        $idsatkecil = $tt['id_satuan'];
        $id_gudang_from = $post['id_gudang_from'];

        $ada_konversi = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang")->num_rows();
        if ($ada_konversi > 0) {
            $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
            $hasil = $konv['hasil'];
            // $this->db->query("call konversi_trans_stock_ke_terkecil($id_barang,$id_gudang_from)");
        } else {
            $hasil = $jumlah;
        }
        //cek nilai yang diinputkan dg master barang
        $row = $this->db->query("select * from trans_stock where id_barang = $id_barang and id_gudang = $id_gudang_from")->row_array();


        $data2 = [
            'id_input_stock' => $id_transaksi,
            'id_barang' => $id_barang,
            'id_gudang_from' => $id_gudang_from,
            'id_satuan' => $id_satuan,
            'jumlah' => $jumlah,
            'jml_konv_terkecil' => $hasil,
            'id_sat_konv_terakhir' => $idsatkecil,
        ];
        $this->db->insert('trans_input_stock_d', $data2);


        return  $id_transaksi;
    }

    public function save_d()
    {
        $post = $this->input->post();
        $id_transaksi = $post['id_transaksi'];
        $id_barang = $post['id_barang'];
        $jumlah = $post['jumlah'];
        $id_satuan = $post['id_satuan'];
        $tt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
        $idsatkecil = $tt['id_satuan'];
        $id_gudang_from = $post['id_gudang_from'];

        $ada_konversi = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang")->num_rows();
        if ($ada_konversi > 0) {
            $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
            $hasil = $konv['hasil'];
            // $this->db->query("call konversi_trans_stock_ke_terkecil($id_barang,$id_gudang_from)");
        } else {
            $hasil = $jumlah;
        }
        //cek nilai yang diinputkan dg master barang
        $row = $this->db->query("select * from trans_stock where id_barang = $id_barang and id_gudang = $id_gudang_from")->row_array();


        $data2 = [
            'id_input_stock' => $id_transaksi,
            'id_barang' => $id_barang,
            'id_gudang_from' => $id_gudang_from,
            'id_satuan' => $id_satuan,
            'jumlah' => $jumlah,
            'jml_konv_terkecil' => $hasil,
            'id_sat_konv_terakhir' => $idsatkecil,
        ];
        $this->db->insert('trans_input_stock_d', $data2);


        return  $id_transaksi;
    }
    public function konfirmasi_m($id_transaksi)
    {
        $query = "SELECT * from trans_input_stock a
        where a.id_input_stock = $id_transaksi
        ";
        return $this->db->query($query)->row_array();
    }

    public function konfirmasi_d($id_transaksi)
    {
        $query = "SELECT * from trans_input_stock_d a
        inner join m_barang b on a.id_barang = b.id_barang
        inner join m_satuan c on a.id_satuan = c.id_satuan
        inner join m_gudang d on a.id_gudang_from = d.id_gudang
        where a.id_input_stock = $id_transaksi order by id_input_stock_d
        ";
        return $this->db->query($query)->result_array();
    }
}
