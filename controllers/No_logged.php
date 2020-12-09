<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class no_logged extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }


    public function pilihsatuan($id_barang)
    {
        $ada = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang")->num_rows();
        if ($ada == 0) {
            $q = "select a.id_satuan,a.nm_satuan from m_satuan a inner join m_barang b on a.id_satuan = b.id_satuan where b.id_barang = $id_barang";
            $data['jenis'] = 0;
        } else {
            $q = "
                select id_barang,id_satuan,nm_satuan,no_urut from (
                select id_barang,a.id_satuan,a.nm_satuan,no_urut from m_satuan a inner join m_satuan_konversi b on a.id_satuan = b.from_satuan where b.id_barang = $id_barang
                union
                select id_barang,a.id_satuan,a.nm_satuan,no_urut from m_satuan a inner join m_satuan_konversi b on a.id_satuan = b.to_satuan where b.id_barang = $id_barang
                ) as x group by id_satuan,nm_satuan order by no_urut
                ";
            $data['jenis'] = 1;
        };
        $data['m_satuan'] = $this->db->query($q)->result_array();
        $this->load->view('trans/v_ajax_satuan', $data);
    }

    public function pilihpr($jenis, $id_supplier, $id_company)
    {
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-90 days', strtotime($datenow)));

        if ($jenis == "po-pr") {
            $query = "SELECT *,a.id,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m,nm_nopol
        ,a.id_company,f.nm_company,b.keterangan as ketitem,b.id as id_pr_d
        FROM permintaan_barang a 
        inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        left join m_nopol e on a.id_nopol = e.id_nopol
        left join m_company f on a.id_company = f.id_company
        inner join permintaan_barang_proses g on a.id = g.permintaan_barang_id
        where a.date_time  between '$dateawal' and '$datenow' and g.status ='submitted'
        and b.is_po = 0 and b.is_penawaran = 0  
        order by b.id desc
        ";
        }

        if ($jenis == "po-edpr") {
            $query = "SELECT *,a.id,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m,nm_nopol
        ,a.id_company,f.nm_company,b.keterangan as ketitem,b.id as id_pr_d
        FROM permintaan_barang a 
        inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        left join m_nopol e on a.id_nopol = e.id_nopol
        left join m_company f on a.id_company = f.id_company
        inner join permintaan_barang_proses g on a.id = g.permintaan_barang_id
        where a.date_time  between '$dateawal' and '$datenow' and g.status ='submitted'
        and b.is_po = 0 and b.is_penawaran = 0 and ( a.id_company = 0 or a.id_company = $id_company)
        order by b.id desc
        ";
        }
        if ($jenis == "po-pnw") {
            $query = "SELECT *,a.id,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m,nm_nopol
        ,a.id_company,f.nm_company,b.keterangan as ketitem,b.id as id_pr_d
        FROM permintaan_barang a 
        inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        left join m_nopol e on a.id_nopol = e.id_nopol
        left join m_company f on a.id_company = f.id_company

        inner join permintaan_barang_penawaran h on b.id = h.id_pr_d
        inner join gbr_penawaran i on i.id_penawaran = h.id_penawaran 
        where b.is_po = 0 and b.is_penawaran = 1 and i.id_supplier = $id_supplier
        
        order by b.id desc
        ";
        }
        if ($jenis == "po-edpnw") {
            $query = "SELECT *,a.id,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m,nm_nopol
        ,a.id_company,f.nm_company,b.keterangan as ketitem,b.id as id_pr_d
        FROM permintaan_barang a 
        inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        left join m_nopol e on a.id_nopol = e.id_nopol
        left join m_company f on a.id_company = f.id_company

        inner join permintaan_barang_penawaran h on b.id = h.id_pr_d
        inner join gbr_penawaran i on i.id_penawaran = h.id_penawaran 
        where b.is_po = 0 and b.is_penawaran = 1 and i.id_supplier = $id_supplier
        and ( a.id_company = 0 or a.id_company = $id_company)
        order by b.id desc
        ";
        }

        if ($jenis == "sj-pr") {
            $query = "SELECT *,a.id,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m,nm_nopol
        ,a.id_company,f.nm_company,b.keterangan as ketitem,b.id as id_pr_d
        FROM permintaan_barang a 
        inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        left join m_nopol e on a.id_nopol = e.id_nopol
        left join m_company f on a.id_company = f.id_company
        inner join permintaan_barang_proses g on a.id = g.permintaan_barang_id
        where a.date_time  between '$dateawal' and '$datenow' and g.status ='submitted'
      
        order by b.id desc
        ";
        }

        if ($jenis == "sj-pnw") {
            $query = "SELECT *,a.id,SUBSTRING(a.date_time,1,10) as tgl, no_permintaan,no_pol,nama_lengkap,lokasi,a.keterangan as ket_m,nm_nopol
        ,a.id_company,f.nm_company,b.keterangan as ketitem,b.id as id_pr_d
        FROM permintaan_barang a 
        inner join permintaan_barang_detail b on a.id = b.permintaan_barang_id
        inner join user c on a.user_id = c.id
        inner join lokasi d on a.lokasi_id = d.id
        left join m_nopol e on a.id_nopol = e.id_nopol
        left join m_company f on a.id_company = f.id_company

        inner join permintaan_barang_penawaran h on b.id = h.id_pr_d
        inner join gbr_penawaran i on i.id_penawaran = h.id_penawaran 
        where b.is_po = 1 and b.is_penawaran = 1 and a.date_time   between '$dateawal' and '$datenow' 
      
        order by b.id desc
        ";
        }


        $data['barang'] = $this->db->query($query)->result_array();
        $data['jenis'] = $jenis;
        $this->load->view('trans/v_modal_pr', $data);
    }
}
