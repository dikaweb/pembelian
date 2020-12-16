<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Po extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model("trans/po_model");
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_company = $row['id_company'];
        $datenow = date("Y-m-d");
        $dateawal = date('Y-m-d', strtotime('-90 days', strtotime($datenow)));
        $url = 'trans/po/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Purchase Order';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        if ($id_company == 0) {
            $query = " select *,nama_lengkap as name from trans_po a
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join user c on a.id_user = c.id
        inner join m_company e on a.id_company = e.id_company
        inner join jns_bayar f on a.jenis_bayar = f.id
        where  jenis = 'PO' and a.tanggal  between '$startDate' and '$endDate' 
        order by a.id_transaksi desc ";
            $data['kota'] = 'ALL';
        } else {
            $query = " select *,nama_lengkap as name from trans_po a
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join user c on a.id_user = c.id
        inner join m_company e on a.id_company = e.id_company
        inner join jns_bayar f on a.jenis_bayar = f.id
        where  jenis = 'PO' and a.id_company = $id_company and a.tanggal  between '$startDate' and '$endDate' 
        order by a.id_transaksi desc ";
            $data['dipilih'] = $this->db->get_where('m_company', ['id_company' => $id_company])->row_array();
            $data['kota'] = $data['dipilih']['nm_company'];
        }

        $data['konfirmasi'] = $this->db->query($query)->result_array();

        $querytbl = " select * from m_company";
        $data['tombol'] = $this->db->query($querytbl)->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_po', $data);
        // $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['title'] = 'Purchase Order';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;
        $data['m_pengirim'] = $this->db->get('m_pengirim')->result_array();
        $data['m_supplier'] = $this->db->get('m_supplier')->result_array();
        $data['barang'] = $this->db->get('m_barang')->result_array();
        $data['m_company'] = $this->db->get('m_company')->result_array();
        $data['m_satuan'] = $this->db->get('m_satuan')->result_array();
        //$id_company = $row['id_company'];
        //$data['header_company'] = $this->db->get_where('m_company', ['id_company' => $id_company])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_po_add', $data);
    }

    public function edit($id_transaksi)
    {
        $data['title'] = 'Purchase Order';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;

        $data['m_company'] = $this->db->get('m_company')->result_array();


        $data['m_satuan'] = $this->db->get('m_satuan')->result_array();
        $data['barang'] = $this->db->get('m_barang')->result_array();

        $data['konfirmasi_m'] = $this->po_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->po_model->konfirmasi_d($id_transaksi);

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_po_edit', $data);
    }

    public function save_m()
    {
        echo json_encode($this->po_model->save_m());
    }

    public function save_d()
    {
        echo json_encode($this->po_model->save_d());
    }

    /////////////////////////supplier
    public function save_supplier()
    {
        echo json_encode($this->po_model->save_supplier());
    }
    public function update_supplier()
    {
        echo json_encode($this->po_model->update_supplier());
    }
    public function delete_supplier()
    {
        echo json_encode($this->po_model->delete_supplier());
    }

    /////////////////////////////barang
    public function save_barang()
    {
        echo json_encode($this->po_model->save_barang());
    }
    public function update_barang()
    {
        echo json_encode($this->po_model->update_barang());
    }
    public function delete_barang()
    {
        echo json_encode($this->po_model->delete_barang());
    }

    /////////////////////end barang
    public function delete_m()
    {
        $post = $this->input->post();
        $nomor = $post["nomor"];
        $nama = $post["nama"];
        $dika = '<div class="alert alert-success" role="alert">No Transaksi ' . $nomor . ', Nama : ' . $nama . ' Berhasil di Hapus!</div>';
        $this->db->where('id_transaksi', $post['idd']);
        $this->db->delete('trans_po_d');
        $this->db->where('id_transaksi', $post['idd']);
        $this->db->delete('trans_po');
        $this->session->set_flashdata('messagez', $dika);
        redirect('trans/po');
    }

    public function delete_d()
    {
        $post = $this->input->post();
        $this->db->where('id_detail', $post['idd']);
        $this->db->delete('trans_po_d');
        $id_transaksi =  $post['idt'];
        $url = 'trans/po/edit/' . $id_transaksi;
        redirect($url);
    }

    public function modal_view($id_transaksi)
    {
        $data['konfirmasi_m'] = $this->po_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->po_model->konfirmasi_d($id_transaksi);
        $this->load->view('trans/v_po_modal_view', $data);
    }
    public function update_m()
    {
        $this->po_model->update_m();
        $this->session->set_flashdata('messagez', 'Data berhasil disimpan');
        $post = $this->input->post();
        $id_transaksi =  $post["txtid_transaksi"];
        $url = 'trans/po/edit/' . $id_transaksi;
        redirect($url);
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
        inner join trans_penawaran_d f on x.id_penawaran = f.id_penawaran
        where  x.status = 2 and x.id_company = $id_company and f.id_supplier = $id_supplier 
        ";
        $data['barang'] = $this->db->query($query)->result_array();
        $data['jenis'] = $jenis;
        $this->load->view('trans/v_modal_penawaran', $data);
    }


    public function pilihbarang($selainjenis)
    {
        //ini dipakai

        $query = "SELECT * FROM m_barang a inner join m_satuan b on a.id_satuan = b.id_satuan where jenis<>'$selainjenis' and status <> 'TIDAK AKTIF' ORDER BY NM_BARANG";
        $data['barang'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_po_modal_barang', $data);
    }
    public function listpenawaran($id_penawaran)
    {
        //ini dipakai
        $query = "SELECT * FROM permintaan_barang_penawaran a 
        inner join gbr_penawaran b on a.id_penawaran = b.id_penawaran
        inner join m_supplier c on b.id_supplier = c.id_supplier where a.id_pr_d= $id_penawaran";
        $data['m_penawaran'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_ajax_penawaran', $data);
    }
    public function pilihsupplier()
    {
        $data['m_supplier'] = $this->db->get('m_supplier')->result_array();
        $this->load->view('trans/v_po_modal_supplier', $data);
    }
    public function pilihpengirim()
    {
        $data['m_pengirim'] = $this->db->get('m_pengirim')->result_array();
        $this->load->view('trans/v_po_modal_pengirim', $data);
    }

    public function kirim()
    {
        $this->session->set_flashdata('messagez', 'Data berhasil dikirim');
        $post = $this->input->post();
        $data = [
            'status' => 2,
        ];
        $this->db->update('trans_po', $data, array('id_transaksi' =>  $post["id_transaksi"]));
        echo json_encode($post["id_transaksi"]);
    }


    public function cetak($id_transaksi)
    {

        $rowf = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_user = $rowf['id'];

        $query = "select id_detail from trans_po_d where id_transaksi = $id_transaksi order by id_detail";
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
        $url = 'trans/po/cetak2/' . $id_transaksi;
        redirect($url);
    }
    public function cetak2($id_transaksi)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['master'] = $this->po_model->konfirmasi_m($id_transaksi);
        $data['detail'] = $this->po_model->konfirmasi_d($id_transaksi);
        $data['judul'] = "PURCHASE ORDER";
        $data['jenis'] = "po";
        $query = "SELECT count(id_transaksi) as jml from trans_po_d a
        inner join m_barang b on a.id_barang = b.id_barang 
        where a.id_transaksi = $id_transaksi  ";

        //$data['xxx'] =  $this->db->query($query)->row_array();
        $this->load->view('cetak/c_po', $data);
    }

    public function update_company_user()
    {
        $id_company = $this->input->post('id_company');
        $nm_company = $this->input->post('nm_company');
        $id_user = $this->input->post('id_user');
        $this->id_company = $id_company;
        $this->db->update("user", $this, array('id' => $id_user));
    }


















    public function export()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $column = 'A';
        $i = 1;
        $sheet->setCellValue($column . $i, "Tanggal");
        $column++;
        $sheet->setCellValue($column . $i, "No Bukti");
        $column++;
        $sheet->setCellValue($column . $i, "Gudang");
        $column++;

        $j = $i + 1;
        $sheet->setCellValue($column . $i, 'Gudang ALL');
        $sheet->setCellValue($column . $j, "Jml");
        $coljmlall = $column;
        $column++;
        $sheet->setCellValue($column . $j, "Akhir");
        $colakhirall = $column;
        $column++;

        $qr = "select distinct(id_gudang),kd_gudang from (
        select distinct(a.id_gudang),kd_gudang from trans_bpb_d a
        inner join m_gudang b on a.id_gudang = b.id_gudang
        where b.is_outstanding = 0
         )as t";
        $gdg_asli = $this->db->query($qr)->result();

        foreach ($gdg_asli  as $do1) {
            $sheet->setCellValue($column . $i, $do1->kd_gudang);
            $j = $i + 1;
            $sheet->setCellValue($column . $j, "Jml");
            $id_gudang = $do1->id_gudang;
            ${"akhir-$id_gudang"} = 0;
            ${"colj-$id_gudang"} = $column;
            $column++;
            $sheet->setCellValue($column . $j, "Akhir");
            ${"cola-$id_gudang"} = $column;
            $column++;
        };

        $qr = "select distinct(a.id_gudang),b.kd_gudang from trans_po_d a
        inner join m_gudang b on a.id_gudang = b.id_gudang
        where b.is_outstanding = 1";
        $gdg_sup = $this->db->query($qr)->result();

        foreach ($gdg_sup as $do2) {
            $sheet->setCellValue($column . $i, $do2->kd_gudang);
            $sheet->setCellValue($column . $j, "Jml");
            $id_gudang = $do2->id_gudang;
            ${"akhir-$id_gudang"} = 0;
            ${"colj-$id_gudang"} = $column;
            $column++;
            $sheet->setCellValue($column . $j, "Akhir");
            ${"cola-$id_gudang"} = $column;
            $column++;
        };

        $i = $i + 2;
        $column = 'A';
        $qr = "
        select no_transaksi, id_gudang, tanggal,date_created,kd_gudang,jumlah,plusminus,is_outstanding,konversi
        from (
        select b.no_transaksi as no_transaksi, a.id_gudang as id_gudang, b.tanggal as tanggal,b.date_created as date_created
        ,c.kd_gudang as kd_gudang,a.jumlah as jumlah ,'+' as plusminus,c.is_outstanding as is_outstanding
        ,konversi_satuan(a.ID_BARANG,a.ID_SATUAN) as konversi
        from trans_po_d a 
        inner join trans_po b on a.id_transaksi = b.id_transaksi 
        inner join m_gudang c on a.id_gudang = c.id_gudang
        union all
        select b.no_transaksi as no_transaksi, d.id_gudang as id_gudang, b.tanggal as tanggal,b.date_created as date_created
        ,c.kd_gudang as kd_gudang,(a.jumlah*-1) as jumlah  ,'-' as plusminus,c.is_outstanding as is_outstanding
        ,konversi_satuan(a.ID_BARANG,a.ID_SATUAN) as konversi
        from trans_bpb_d a 
        inner join trans_po_d d on a.id_po_d = d.id_detail
        inner join trans_bpb b on a.id_transaksi = b.id_transaksi 
        inner join m_gudang c on d.id_gudang = c.id_gudang
        union all
        select b.no_transaksi as no_transaksi, a.id_gudang as id_gudang, b.tanggal as tanggal,b.date_created as date_created
        ,c.kd_gudang as kd_gudang,a.jumlah as jumlah  ,'+' as plusminus,c.is_outstanding as is_outstanding
        ,konversi_satuan(a.ID_BARANG,a.ID_SATUAN) as konversi
        from trans_bpb_d a 
        inner join trans_bpb b on a.id_transaksi = b.id_transaksi 
        inner join m_gudang c on a.id_gudang = c.id_gudang
        ) as t order by tanggal,date_created,plusminus desc
        ";
        $permintaan_barang_list = $this->db->query($qr)->result();
        $akhir_gudangall = 0;
        $j = $i;
        foreach ($permintaan_barang_list as $do) {
            $column = 'A';
            $sheet->setCellValue($column . $j, $do->tanggal);
            $column++;
            $sheet->setCellValue($column . $j, $do->no_transaksi . ' ' . $do->plusminus);
            $column++;
            $sheet->setCellValue($column . $j, $do->kd_gudang);
            $id_gudang = $do->id_gudang;
            ${"akhir-$id_gudang"} =  ${"akhir-$id_gudang"} + ($do->jumlah * $do->konversi);
            $sheet->setCellValue(${"colj-$id_gudang"} . $j,  qtyrp($do->jumlah * $do->konversi));
            $sheet->setCellValue(${"cola-$id_gudang"} . $j, ${"akhir-$id_gudang"});
            if ($do->is_outstanding == 0) {
                $akhir_gudangall =  $akhir_gudangall + ($do->jumlah * $do->konversi);
                $sheet->setCellValue('D' . $j,  qtyrp($do->jumlah * $do->konversi));
                $sheet->setCellValue('E' . $j,  qtyrp($akhir_gudangall));
                //$sheet->setCellValue($coljmlall . $j, $do->plusminus . qtyrp($do->jumlah));
                //$sheet->setCellValue($colakhirall . $j, $do->plusminus . qtyrp($akhir_gudangall));
            }
            $j = $j + 1;
        }



        foreach (range('D', 'Z') as $columnID) {
            $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                ->setWidth(6);
        }


        $writer = new Xlsx($spreadsheet);

        $filename = 'Stock Export ';
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        $writer->save('php://output');
    }


    function get_data_barang()
    {
        $this->load->model('trans/Barang_model');
        $list = $this->Barang_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $rows) { {

                $data[] = array(

                    '<button id="btnmdlpilihbarang" class="badge-primary" data-nm="' . $rows->nm_barang . '" data-id="' . $rows->id_barang . '" data-dismiss="modal">Pilih</button>
                    ',
                    $rows->kd_barang,
                    $rows->nm_barang,
                    $rows->nm_satuan,
                    $rows->kelompok
                );
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Barang_model->count_all(),
            "recordsFiltered" => $this->Barang_model->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    public function pilihbarang0()
    {
        //ini dipakai
        $this->load->view('trans/v_modal_barang_serverside');
    }
}
