<?php
defined('BASEPATH') or exit('No direct script access allowed');

class spk_model extends CI_Model
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
            // $no_po = "SPK-"  . $kd_company . '.' . sprintf("%04s", $no_urut);


            $query2 = $this->db->query("select bulan_romawi('$tgl_upload') as tes");
            $row6 = $query2->row_array();

            $quer = $this->db->query("select kode_c from m_company where id_company = $id_company")->row_array();;
            $kd_company = $quer['kode_c'];
            $no_po = "SPK-" . sprintf("%04s", $no_urut) . '/' . $kd_company . '/' . $row6['tes'] . '/' . $tahun;
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
                'up1' => $post['txtup'],
                'keterangan' => $post['txt_keterangan'],
                'keterangan2' => $post['txt_keterangan2'],
                'jenis_bayar' => $post['txtjenis_bayar'],
                'id_company' => $post['id_company'],
                'id_ppn_pph' => $post['pph'],
                'nilai_pph' => $post['nilai_pph'],
                'tahun' => $tahun,
                'jenis' => 'SPK',
            ];
            $this->db->insert('trans_po', $data);


            $row = $this->db->query('select id_transaksi from trans_po where id_transaksi = (select max(id_transaksi) from trans_po)')->row_array();
            $id_transaksi = $row['id_transaksi'];



            $data2 = [
                'id_transaksi' => $id_transaksi,
                'id_barang' => $post['id_barang'],
                'nm_barang' => $post['nm_barang'],
                'id_gudang' => $id_gudang,
                'id_satuan' => $post['id_satuan'],
                'jumlah' => $post['jumlah'],
                'total' => $post['jumlah'] * $post['harga'],
                'harga' => $post['harga'],
                'jenis_reff' => $post['jenis_reff'],
                'id_reff' => $post['id_reff'],
                'jenis' => 'SPK',
            ];
            $this->db->insert('trans_po_d', $data2);

            $data3 = [
                'up_sp' => $post['txtup'],
            ];
            $this->db->update('m_supplier', $data3, array('id_supplier' => $post["id_rekanan1"]));

            return  $id_transaksi;
        }
    }

    public function update_m()
    {
        $post = $this->input->post();
        $data3 = [
            'up_sp' => $post['txtup'],
        ];
        $this->db->update('m_supplier', $data3, array('id_supplier' => $post["txtid_rekanan1"]));

        $q11 = $this->db->get_where('trans_po', array('id_transaksi' =>  $post["txtid_transaksi"]))->row_array();
        $id_ppn_pph = $q11['id_ppn_pph'];
        $vnilai_pph_old =  $q11['nilai_pph'];
        $vnilai_pph_new = $post['nilai_pph'];

        if ($id_ppn_pph == $post['txt_ppn'] && $vnilai_pph_old == $vnilai_pph_new) {
            $data = [
                'no_transaksi' => $post['txtno_transaksi'],
                'tanggal' => $post['tgl'],
                'id_supplier' => $post['txtid_rekanan1'],
                'note_po' => $post['txtnote_po'],
                'up1' => $post['txtup'],
                'id_ppn_pph' => $post['txt_pph'],
                'keterangan' => $post['txt_keterangan'],
                'keterangan2' => $post['txt_keterangan2'],
                'jenis_bayar' => $post['txtjenis_bayar'],
                'nilai_pph' => $post['nilai_pph'],
            ];
        } else {
            $id_transaksi = $post["txtid_transaksi"];
            $q1 = $this->db->query("select sum(total) as vtotal from trans_po_d where id_transaksi = $id_transaksi")->row_array();
            $vtotal = $q1['vtotal'];

            if ($post['txt_pph'] == 2) {
                $vppnrp = (($vtotal * $vnilai_pph_new) / 100);
                $vgrandtotal = $vtotal + $vppnrp;
            } else if ($post['txt_pph'] == 1) {
                $vgrandtotal = $vtotal;
                $vtotal = ((100 / (100 + $vnilai_pph_new)) * $vtotal);
                $vppnrp = $vgrandtotal - $vtotal;
            } else if ($post['txt_pph'] == 3) {
                $vppnrp = 0;
                $vgrandtotal = $vtotal;
            }

            $data = [
                'no_transaksi' => $post['txtno_transaksi'],
                'tanggal' => $post['tgl'],
                'id_supplier' => $post['txtid_rekanan1'],
                'note_po' => $post['txtnote_po'],
                'up1' => $post['txtup'],
                'id_ppn_pph' => $post['txt_pph'],
                'keterangan' => $post['txt_keterangan'],
                'keterangan2' => $post['txt_keterangan2'],
                'jenis_bayar' => $post['txtjenis_bayar'],
                'nilai_pph' => $post['nilai_pph'],
                'total' => $vtotal,
                'ppnrp' => $vppnrp,
                'grandtotal' => $vgrandtotal,
            ];
        }
        $this->db->update('trans_po', $data, array('id_transaksi' =>  $post["txtid_transaksi"]));
    }

    public function save_d()
    {
        $post = $this->input->post();
        $id_company = $this->input->post("id_company");
        $q11 = $this->db->query("select id_gudang from m_gudang where id_company = $id_company and is_outstanding = 1")->row_array();
        $id_gudang = $q11['id_gudang'];

        $data = [
            'id_transaksi' => $post['id_transaksi'],
            'id_barang' => $post['id_barang'],
            'nm_barang' => $post['nm_barang'],
            'id_satuan' => $post['id_satuan'],
            'jumlah' => $post['jumlah'],
            'total' => $post['jumlah'] * $post['harga'],
            'id_gudang' => $id_gudang,
            'harga' => $post['harga'],
            'jenis_reff' => $post['jenis_reff'],
            'id_reff' => $post['id_reff'],
            'jenis' => 'SPK',
        ];
        $this->db->insert('trans_po_d', $data);
        return $post['id_transaksi'];
    }
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

    public function konfirmasi_m_app($id_transaksi)
    {
        $query = "SELECT *,id_transaksi as id_transaksi,no_transaksi as no_transaksi,note_po as note_po from trans_po a 
        left join m_supplier b on a.id_supplier = b.id_supplier
        inner join m_company c on a.id_company = c.id_company
        inner join stat_ppn d on a.id_ppn_pph = d.id_ppn_pph
        where a.id_transaksi = $id_transaksi
        ";
        return $this->db->query($query)->row_array();
    }

    public function konfirmasi_d_app($id_transaksi)
    {
        $query = "SELECT * from trans_po_d a 
        inner join m_barang b on a.id_barang = b.id_barang
        left join m_satuan c on a.id_satuan = c.id_satuan
       
        where a.id_transaksi = $id_transaksi order by id_detail
        ";
        return $this->db->query($query)->result_array();
    }
}
