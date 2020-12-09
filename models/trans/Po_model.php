<?php
defined('BASEPATH') or exit('No direct script access allowed');

class po_model extends CI_Model
{
    public function save_m()
    {
        $id_company = $this->input->post("id_company");
        $q11 = $this->db->query("select id_gudang from m_gudang where id_company = $id_company and is_outstanding = 1");
        $ct = $q11->num_rows();
        if ($ct == 0) {
            return  $ct;
        } else {
            $row11 = $q11->row_array();
            $id_gudang = $row11['id_gudang'];
            $post = $this->input->post();
            $my_date = date("Y-m-d H:i:s");
            $tahun = date('Y', strtotime($this->input->post("tanggal")));


            $tgl_upload = $this->input->post("tanggal");
            $tahun = date('Y', strtotime($tgl_upload));
            //$id_company = 1;

            $query1 = $this->db->query("select no_urut as max_id from trans_po where no_urut = (SELECT MAX(no_urut) FROM trans_po where tahun = $tahun and id_company = $id_company)");
            $row = $query1->row_array();
            if (isset($row['max_id'])) {
                $no_urut = $row['max_id'] + 1;

                $mulai = $row['max_id'] - 10;
                $query2 = $this->db->query("select no_urut from trans_po where no_urut > $mulai and tahun = $tahun and id_company = $id_company order by no_urut");
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
            // $no_po = "PO-"  . $kd_company . '.' . sprintf("%04s", $no_urut);

            $query2 = $this->db->query("select bulan_romawi('$tgl_upload') as tes");
            $row6 = $query2->row_array();

            $quer = $this->db->query("select kode_c from m_company where id_company = $id_company")->row_array();;
            $kd_company = $quer['kode_c'];
            $no_po = "PO-" . sprintf("%04s", $no_urut) . '/' . $kd_company . '/' . $row6['tes'] . '/' . $tahun;
            $data = [
                //'no_transaksi' => $post['no_transaksi'],
                'no_transaksi' => $no_po,
                'no_urut' => $no_urut,
                'tanggal' => $post['tanggal'],
                'id_supplier' => $post['id_rekanan1'],
                'id_user' => $post['id_user'],
                'date_created' => $my_date,
                'status' => 1,
                'note_po' => $post['note_po'],
                'keterangan' => $post['txt_keterangan'],
                'keterangan2' => $post['txt_keterangan2'],
                'jenis_bayar' => $post['txtjenis_bayar'],
                'up1' => $post['txtup'],
                'nilai_pph' => 10,
                'id_company' => $id_company,
                'id_ppn_pph' => $post['ppn'],
                'jenis' => 'PO',
                'tahun' => $tahun
            ];
            $this->db->insert('trans_po', $data);


            $row = $this->db->query('select id_transaksi from trans_po where id_transaksi = (select max(id_transaksi) from trans_po)')->row_array();
            $id_transaksi = $row['id_transaksi'];
            $id_barang = $post['id_barang'];
            $jumlah = $post['jumlah'];
            $id_satuan = $post['id_satuan'];
            $tt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
            $idsatkecil = $tt['id_satuan'];

            $ada_konversi = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang")->num_rows();
            if ($ada_konversi > 0) {
                $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
                $hasil = $konv['hasil'];
            } else {
                $hasil = $jumlah;
            }

            $data2 = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $id_barang,
                'nm_barang' => $post['nm_barang'],
                'id_gudang' => $id_gudang,
                'id_satuan' => $id_satuan,
                'jumlah' => $jumlah,
                'jml_konv_terkecil' => $hasil,
                'id_sat_konv_terakhir' => $idsatkecil,
                'harga' => $post['harga'],
                'jenis_reff' => $post['jenis_reff'],
                'jenis' => 'PO',
                'id_reff' => $post['id_reff'],
            ];
            $this->db->insert('trans_po_d', $data2);

            $data3 = [
                'up_sp' => $post['txtup'],
            ];
            $this->db->update('m_supplier', $data3, array('id_supplier' => $post["id_rekanan1"]));

            return  (int)$id_transaksi;
        }
    }

    public function update_m()
    {
        $post = $this->input->post();
        $data3 = [
            'up_sp' => $post['txtup'],
        ];
        $this->db->update('m_supplier', $data3, array('id_supplier' => $post["txtid_rekanan1"]));
        $data = [
            'no_transaksi' => $post['txtno_transaksi'],
            'tanggal' => $post['tgl'],
            'id_supplier' => $post['txtid_rekanan1'],
            'note_po' => $post['txtnote_po'],
            'up1' => $post['txtup'],
            'id_ppn_pph' => $post['txt_ppn'],
            'keterangan' => $post['txt_keterangan'],
            'keterangan2' => $post['txt_keterangan2'],
            'jenis_bayar' => $post['txtjenis_bayar'],
        ];
        $this->db->update('trans_po', $data, array('id_transaksi' =>  $post["txtid_transaksi"]));
    }

    public function save_d()
    {
        $post = $this->input->post();
        $id_company = $this->input->post("id_company");
        $q11 = $this->db->query("select id_gudang from m_gudang where id_company = $id_company and is_outstanding = 1")->row_array();
        $id_gudang = $q11['id_gudang'];

        $id_barang = $post['id_barang'];
        $jumlah = $post['jumlah'];
        $id_satuan = $post['id_satuan'];
        $tt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang")->row_array();
        $idsatkecil = $tt['id_satuan'];

        $ada_konversi = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang")->num_rows();
        if ($ada_konversi > 0) {
            $konv = $this->db->query("select (konversi_satuan($id_barang,$id_satuan) * $jumlah)  as hasil ")->row_array();
            $hasil = $konv['hasil'];
        } else {
            $hasil = $jumlah;
        }

        $data = [
            'id_transaksi' => $post['id_transaksi'],
            'id_barang' => $post['id_barang'],
            'nm_barang' => $post['nm_barang'],
            'id_satuan' => $post['id_satuan'],
            'jumlah' => $post['jumlah'],
            'jml_konv_terkecil' => $hasil,
            'id_sat_konv_terakhir' => $idsatkecil,
            'id_gudang' => $id_gudang,
            'harga' => $post['harga'],
            'jenis' => 'PO',
            'jenis_reff' => $post['jenis_reff'],
            'id_reff' => $post['id_reff'],
        ];
        $this->db->insert('trans_po_d', $data);
        return $post['id_transaksi'];
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
        //$row = $this->db->query("select count(id_supplier) as ct from trans_po where id_supplier = $id")->row_array();
        //if ($row['ct'] == 0) {
        $data = [
            'nm_supplier' => $post['nm_supplier'],
            'alamat_sp' => $post['alamat_sp'],
            'up_sp' => $post['up_sp'],
            'no_rek' => $post['no_rek'],
        ];
        $this->db->update('m_supplier', $data, array('id_supplier' =>  $post["id_supplier"]));
        //}
        return 0;
    }
    public function delete_supplier()
    {
        $post = $this->input->post();
        $id = $post["id_supplier"];
        $row = $this->db->query("select count(id_supplier) as ct from trans_po where id_supplier = $id")->row_array();
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
            'id_satuan' => $post['satuan'],
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
                'id_satuan' => $post['satuan'],
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
    public function konfirmasi_m($id_transaksi)
    {
        $query = "SELECT * from trans_po a 
        left join m_supplier b on a.id_supplier = b.id_supplier
        inner join m_company c on a.id_company = c.id_company
        inner join stat_ppn d on a.id_ppn_pph = d.id_ppn_pph
        where a.id_transaksi = $id_transaksi
        ";
        return $this->db->query($query)->row_array();
    }

    public function konfirmasi_d($id_transaksi)
    {
        $query = "SELECT * from trans_po_d a 
        inner join m_barang b on a.id_barang = b.id_barang
        left join m_satuan c on a.id_satuan = c.id_satuan
       
        where a.id_transaksi = $id_transaksi order by id_detail
        ";
        return $this->db->query($query)->result_array();
    }
}
