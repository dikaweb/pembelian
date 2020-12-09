<?php
defined('BASEPATH') or exit('No direct script access allowed');

class sj_model extends CI_Model
{
    public function save_m()
    {
        $id_company = $this->input->post("id_company");

        $post = $this->input->post();
        $my_date = date("Y-m-d H:i:s");
        $tahun = date('Y', strtotime($this->input->post("tanggal")));


        $tgl_upload = $this->input->post("tanggal");
        $tahun = date('Y', strtotime($tgl_upload));
        //$id_company = 1;

        $query1 = $this->db->query("select no_urut as max_id from trans_sj where no_urut = (SELECT MAX(no_urut) FROM trans_sj where tahun = $tahun and id_company = $id_company)");
        $row = $query1->row_array();
        if (isset($row['max_id'])) {
            $no_urut = $row['max_id'] + 1;

            $mulai = $row['max_id'] - 10;
            $query2 = $this->db->query("select no_urut from trans_sj where no_urut > $mulai and tahun = $tahun and id_company = $id_company order by no_urut");
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
        // $quer = $this->db->query("select kode_c from m_company where id_company = $id_company")->row_array();;
        // $kd_company = $quer['kode_c'];
        // $no_sj = "SJGD-" . $kd_company . '.' . sprintf("%04s", $no_urut);

        $query2 = $this->db->query("select bulan_romawi('$tgl_upload') as tes");
        $row6 = $query2->row_array();

        $quer = $this->db->query("select kode_c from m_company where id_company = $id_company")->row_array();;
        $kd_company = $quer['kode_c'];
        $no_sj = "SJ-" . sprintf("%04s", $no_urut) . '/' . $kd_company . '/' . $row6['tes'] . '/' . $tahun;
        $data = [
            'no_transaksi' => $no_sj,
            'tanggal' => $post['tanggal'],
            'no_urut' => $no_urut,
            'tahun' => $tahun,
            'id_penerima' => $post['id_penerima'],
            'id_user' => $post['id_user'],
            'date_created' => $my_date,
            'status' => 1,
            'note_sj_gd' => $post['note_sj_gd'],
            'up_penerima' => $post['txtup'],
            'id_company' => $post['id_company'],
            'id_pengirim' => $post['id_pengirim'],
            'keterangan' => $post['txt_keterangan'],
            'keterangan2' => $post['txt_keterangan2'],
            'id_gudang' => $post['id_gudang'],
        ];
        $this->db->insert('trans_sj', $data);

        $row = $this->db->query('select id_transaksi from trans_sj where id_transaksi = (select max(id_transaksi) from trans_sj)')->row_array();
        $id_transaksi = $row['id_transaksi'];

        $id_barang = $post['id_barang'];
        $id_satuan = $post['id_satuan'];
        $jumlah = $post['jumlah'];
        $id_company =  $post['id_company'];
        $rowgd = $this->db->query("SELECT * FROM m_gudang where is_kapasan = 1 and  id_company = $id_company")->row_array();
        $id_gudang_asal = $rowgd['id_gudang'];
        $rt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
        $id_sat_terkecil = $rt['id_satuan'];
        $this->db->query("call konversi_trans_stock_ke_terkecil($id_barang,$id_gudang_asal)");
        $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
        $hasil = $konv['hasil'];
        $row = $this->db->query("select * from trans_stock where id_barang = $id_barang and id_gudang = $id_gudang_asal")->row_array();
        $jml_stock = $row['qty'];

        $akhir = $jml_stock - $hasil;
        if ($akhir >= 0) {
            $data2 = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $id_barang,
                'id_gudang_to' => $post['id_gudang'],
                'id_gudang_from' => $id_gudang_asal,
                'jml_konv_terkecil' => $hasil,
                'id_sat_konv_terakhir' => $id_sat_terkecil,
                'id_satuan' => $id_satuan,
                'jumlah' => $jumlah,
                'nm_barang' => $post['nm_barang'],
                'jenis_reff' => $post['jenis_reff'],
                'id_reff' => $post['id_reff'],
            ];
            $this->db->insert('trans_sj_d', $data2);
        } else {
            $dika = '<div class="alert alert-danger" role="alert">Jumlah ' . $jumlah . ', Nilai Konversi terkecil: ' . $hasil .  ', Sisa Stock : ' . $jml_stock . '. <br> Gagal disimpan, Jumlah melebihi dari Stock <br> Ulangi Input Barang !!!</div>';
            $this->session->set_flashdata('messagez', $dika);
        }

        $data3 = [
            'up_pn' => $post['txtup'],
        ];
        $this->db->update('m_penerima', $data3, array('id_penerima' => $post["id_penerima"]));

        return  $id_transaksi;
    }

    public function update_m()
    {
        $post = $this->input->post();
        $data3 = [
            'up_sp' => $post['txtup'],
        ];
        //$this->db->update('m_penerima', $data3, array('id_penerima' => $post["txtid_pn"]));
        $data = [
            'tanggal' => $post['tgl'],
            'id_penerima' => $post['txtid_pn'],
            'id_pengirim' => $post['txtid_kr'],
            'note_sj_gd' => $post['txtnote'],
            'up_penerima' => $post['txtup'],
            'keterangan' => $post['txt_keterangan'],
            'keterangan2' => $post['txt_keterangan2'],
        ];
        $this->db->update('trans_sj', $data, array('id_transaksi' =>  $post["txtid_transaksi"]));
    }

    public function save_d()
    {
        $post = $this->input->post();
        $id_barang = $post['id_barang'];
        $id_satuan = $post['id_satuan'];
        $jumlah = $post['jumlah'];

        $id_company =  $post['id_company'];
        $rowgd = $this->db->query("SELECT * FROM m_gudang where is_kapasan = 1 and  id_company = $id_company")->row_array();
        $id_gudang_asal = $rowgd['id_gudang'];

        $rt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
        $id_sat_terkecil = $rt['id_satuan'];
        $this->db->query("call konversi_trans_stock_ke_terkecil($id_barang,$id_gudang_asal)");
        $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
        $hasil = $konv['hasil'];
        $row = $this->db->query("select * from trans_stock where id_barang = $id_barang and id_gudang = $id_gudang_asal")->row_array();
        $jml_stock = $row['qty'];


        $akhir = $jml_stock - $hasil;
        if ($akhir >= 0) {
            $data2 = [
                'id_transaksi' => $post['id_transaksi'],
                'id_barang' => $id_barang,
                'id_gudang_to' => $post['id_gudang'],
                'id_gudang_from' => $id_gudang_asal,
                'id_satuan' => $id_satuan,
                'jumlah' => $jumlah,
                'jml_konv_terkecil' => $hasil,
                'id_sat_konv_terakhir' => $id_sat_terkecil,
                'nm_barang' => $post['nm_barang'],
                'jenis_reff' => $post['jenis_reff'],
                'id_reff' => $post['id_reff'],
            ];
            $this->db->insert('trans_sj_d', $data2);
        } else {
            $dika = '<div class="alert alert-danger" role="alert">Jumlah ' . $jumlah . ', Nilai Konversi terkecil: ' . $hasil .  ', Sisa Stock : ' . $jml_stock . '. <br> Gagal disimpan, Jumlah melebihi dari Stock <br> Ulangi Input Barang !!!</div>';
            $this->session->set_flashdata('messagez', $dika);
        }
        return $post['id_transaksi'];
    }
    //////////////////////////////penerima
    public function save_penerima()
    {
        $post = $this->input->post();
        $data = [
            'nm_penerima' => $post['nm_penerima'],
            'alamat_pn1' => $post['alamat_pn1'],
            'up_pn' => $post['up_pn'],
        ];
        $this->db->insert('m_penerima', $data);
    }

    public function update_penerima()
    {
        $post = $this->input->post();
        $id = $post["id_penerima"];
        $row = $this->db->query("select count(id_penerima) as ct from trans_sj where id_penerima = $id")->row_array();
        if ($row['ct'] == 0) {
            $data = [
                'nm_penerima' => $post['nm_penerima'],
                'alamat_pn1' => $post['alamat_pn1'],
                'up_pn' => $post['up_pn'],
            ];
            $this->db->update('m_penerima', $data, array('id_penerima' =>  $post["id_penerima"]));
        }
        return $row['ct'];
    }
    public function delete_penerima()
    {
        $post = $this->input->post();
        $id = $post["id_penerima"];
        $row = $this->db->query("select count(id_penerima) as ct from trans_sj where id_penerima = $id")->row_array();
        if ($row['ct'] == 0) {
            $this->db->where('id_penerima', $post['id_penerima']);
            $this->db->delete('m_penerima');
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
        $row = $this->db->query("select count(id_barang) as ct from trans_sj_d where id_barang = $id")->row_array();
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
        $row = $this->db->query("select count(id_barang) as ct from trans_sj_d where id_barang = $id")->row_array();
        if ($row['ct'] == 0) {
            $this->db->where('id_barang', $post['id_barang']);
            $this->db->delete('m_barang');
        }
        return $row['ct'];
    }
    ////////////////end barang
    public function konfirmasi_m($id_transaksi)
    {
        $query = "SELECT * from trans_sj a 
        inner join m_penerima b on a.id_penerima = b.id_penerima
        inner join m_gudang c on a.id_gudang = c.id_gudang
        where a.id_transaksi = $id_transaksi
        ";
        return $this->db->query($query)->row_array();
    }

    public function cetak_m($id_transaksi)
    {

        $query = "SELECT * from trans_sj a 
       
        inner join m_penerima c on a.id_penerima = c.id_penerima
        inner join m_company d on a.id_company = d.id_company
        inner join m_gudang e on a.id_gudang = e.id_gudang
        inner join user f on a.id_user = f.id
        where a.id_transaksi = $id_transaksi
        ";

        return $this->db->query($query)->row_array();
    }

    public function konfirmasi_d($id_transaksi)
    {
        $query = "SELECT * from trans_sj_d a 
        inner join m_barang b on a.id_barang = b.id_barang
        left join m_satuan c on a.id_satuan = c.id_satuan
        where a.id_transaksi = $id_transaksi order by id_detail
        ";
        return $this->db->query($query)->result_array();
    }
}
