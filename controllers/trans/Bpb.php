<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class bpb extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
        $this->load->model("trans/bpb_model");
    }


    public function index()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $datenow = date("Y-m-d");
        $this->session->set_flashdata('messagez', $this->session->userdata('messagez'));
        $dateawal = date('Y-m-d', strtotime('-90 days', strtotime($datenow)));
        $url = 'trans/bpb/view/0/' . $dateawal . '/' . $datenow;
        redirect($url);
    }


    public function view($id_company, $startDate, $endDate)
    {
        $data['title'] = 'Serah Terima PO/SPK';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        if ($id_company == 0) {
            $query = " select *,nama_lengkap as name from trans_bpb a
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join user c on a.id_user = c.id
        inner join m_company d on a.id_company = d.id_company
        where a.tanggal  between '$startDate' and '$endDate' 
        order by a.tanggal";
            $data['kota'] = 'ALL';
        } else {
            $query = " select *,nama_lengkap as name from trans_bpb a
        left join m_supplier b on a.id_supplier = b.id_supplier
        left join user c on a.id_user = c.id
        inner join m_company d on a.id_company = d.id_company
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
        $this->load->view('trans/v_bpb', $data);
        // $this->load->view('templates/footer');
    }

    public function add()
    {
        $data['title'] = 'Serah Terima PO/SPK';
        $row = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['user'] = $row;
        $query = " 
        
        select a.jenis,b.nm_supplier as nm_supplier,a.id_transaksi as id_transaksi, a.no_transaksi as no_transaksi,
        a.tanggal as tanggal,c.kode_c as nm_company,a.id_company,a.id_supplier
        from trans_po a
        left join m_supplier b on a.id_supplier = b.id_supplier
        inner join m_company c on a.id_company = c.id_company
        where status in(3,4)
         ";


        $data['konfirmasi'] = $this->db->query($query)->result_array();

        $querytbl = " select * from m_company";
        $data['tombol'] = $this->db->query($querytbl)->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_bpb_add', $data);
    }

    public function edit($id_transaksi)
    {
        $data['title'] = 'Serah Terima PO/SPK';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        $data['konfirmasi_m'] = $this->bpb_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->bpb_model->konfirmasi_d($id_transaksi);
        $data['gbr'] = $this->bpb_model->gbr($id_transaksi);

        $this->session->set_flashdata('messagez', $this->session->userdata('messagez'));
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_bpb_edit', $data);
    }
    public function add2($id_po_spk)
    {
        $data['title'] = 'Serah Terima PO/SPK';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $this->load->model("trans/po_model");
        $data['konfirmasi_m'] = $this->po_model->konfirmasi_m($id_po_spk);
        $data['konfirmasi_d'] = $this->bpb_model->add_d($id_po_spk);

        $id_company = $data['konfirmasi_m']['id_company'];
        $data['m_gudang'] = $this->db->get_where('m_gudang', ['id_company' => $id_company, 'is_outstanding' => 0])->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('trans/v_bpb_add2', $data);
    }

    public function save_m()
    {
        $post = $this->input->post();


        $tahun = date('Y', strtotime($this->input->post("tanggal")));
        $id_gudang = $this->input->post('id_gudang');
        $id_po_spk = $post['id_transaksi'];

        $pospk = $this->db->get_where('trans_po', ['id_transaksi' => $id_po_spk])->row_array();
        $jenis = $pospk['jenis'];
        $id_company = $pospk['id_company'];



        $tgl_upload = date("Y-m-d");
        $tahun = date('Y', strtotime($tgl_upload));
        //$id_company = 1;


        $query1 = $this->db->query("select no_urut as max_id from trans_bpb where no_urut = (SELECT MAX(no_urut) FROM trans_bpb where tahun = $tahun and id_company = $id_company)");
        $row = $query1->row_array();
        if (isset($row['max_id'])) {
            $no_urut = $row['max_id'] + 1;

            $mulai = $row['max_id'] - 10;
            $query2 = $this->db->query("select no_urut from trans_bpb where no_urut > $mulai and tahun = $tahun and id_company = $id_company order by no_urut");
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

        //cek dulu apakah inputaan angka semua
        $jml_input = $this->input->post('jml_input');
        for ($x = 0; $x < sizeof($jml_input); $x++) {
            if (is_numeric($jml_input[$x]) != 1) {
                $dika = '<div class="alert alert-danger" role="alert">Terdapat jumlah input yang bukan angka, Silahkan Ulangi</div>';
                $this->session->set_flashdata('messagez', $dika);
                $url = 'trans/bpb/add2/' . $id_po_spk;
                redirect($url);
            }
        }

        $query2 = $this->db->query("select bulan_romawi('$tgl_upload') as tes");
        $row6 = $query2->row_array();

        $quer = $this->db->query("select kode_c from m_company where id_company = $id_company")->row_array();;
        $kd_company = $quer['kode_c'];
        $no_penawaran = "BPB-" . sprintf("%04s", $no_urut) . '/' . $kd_company . '/' . $row6['tes'] . '/' . $tahun;
        $nilai_pph =  $pospk['nilai_pph'];
        if ($pospk['id_ppn_pph'] == 3) {
            $nilai_pph = 0;
        }
        $data = [
            'no_bpb' => $no_penawaran,
            'no_urut' => $no_urut,
            'id_supplier' => $pospk['id_supplier'],
            'id_ppn_pph' => $pospk['id_ppn_pph'],
            'nilai_pph' => $nilai_pph,
            'id_po_spk' => $id_po_spk,
            'id_user' => $this->session->userdata('id_loginz'),
            'id_company' => $id_company,
            'jenis' => $jenis,
            'ket_nv' => $pospk['note_po'],
            'id_gudang' =>  $id_gudang,
            'tahun' => $tahun
        ];
        $this->db->insert('trans_bpb', $data);
        $row = $this->db->query('select max(id_bpb) as id_transaksi from trans_bpb')->row_array();
        $id_transaksi = $row['id_transaksi'];



        $id_barang = $this->input->post('id_barang');
        $id_satuan = $this->input->post('id_satuan');
        $nm_barang = $this->input->post('nm_barang');
        $harga = $this->input->post('harga');

        $id_po_d = $this->input->post('id_po_d');

        $updateArray = array();
        for ($x = 0; $x < sizeof($id_po_d); $x++) {

            $rt = $this->db->query("select id_satuan from m_barang where id_barang = $id_barang[$x]")->row_array();
            $id_sat_terkecil = $rt['id_satuan'];
            // update dulu po_d ke satuan terkecil
            $this->db->query("update trans_po_d set jml_konv_terkecil = konversi_satuan($id_barang[$x],$id_satuan[$x]) * jumlah,id_sat_konv_terakhir = $id_sat_terkecil where id_detail = $id_po_d[$x]");

            //cek nilai yang diinputkan dg po_d terkecil
            $konv = $this->db->query("select (konversi_satuan($id_barang[$x],$id_satuan[$x]) * $jml_input[$x])  as hasil ")->row_array();
            $hasil = $konv['hasil'];
            $row = $this->db->query("select * from trans_po_d where id_detail = $id_po_d[$x]")->row_array();

            $sisa_po = $row['jml_konv_terkecil'] - $row['jml_dt_konv_terkecil'];

            $akhir = (float)$sisa_po - (float)$hasil;
            var_dump('harga : ' .  (float)$harga[$x]);
            var_dump('jml : ' . (float)$jml_input[$x]);
            var_dump('total : ' . (float)$harga[$x] * (float)$jml_input[$x]);
            //var_dump('id po : '.$id_po_d[$x]);
            //var_dump('id_barang : '.$id_barang[$x]);
            //die();
            //$akhir = 1;
            if ((float)$jml_input[$x] > 0) {
                if ($akhir >= 0) {
                    $updateArray[] = array(
                        'id_bpb' => $id_transaksi,
                        'id_satuan' => $id_satuan[$x],
                        'id_barang' => $id_barang[$x],
                        'jumlah' =>  $jml_input[$x],
                        'id_gudang' =>  $id_gudang,
                        'id_po_d' =>  $id_po_d[$x],
                        'jenis' => $jenis,
                        'nm_barang' => $nm_barang[$x],
                        'harga' => $harga[$x],
                        'total' => (float)$harga[$x] * (float)$jml_input[$x],
                    );
                } else {
                    $dika = '<div class="alert alert-danger" role="alert">Terdapat data yang melebihi jumlah PO, silahkan tambah manual PO tersebut!</div>';
                    $this->session->set_flashdata('messagez', $dika);
                }
            }
        }

        if (sizeof($updateArray) > 0) {
            $this->db->insert_batch('trans_bpb_d', $updateArray);
            $this->bpb_model->upload_m($id_transaksi);
            $url = 'trans/bpb/edit/' . $id_transaksi;
        } else {
            $dika = '<div class="alert alert-danger" role="alert">Tidak ada data yang bisa disimpan karena jumlah yg diinputkan melebihi sisa, silahkan ulangi!</div>';
            $this->session->set_flashdata('messagez', $dika);
            $this->db->where('id_bpb', $id_transaksi);
            $this->db->delete('trans_bpb');
            $url = 'trans/bpb/add2/' . $id_po_spk;
        }
        redirect($url);
    }

    public function save_d()
    {
        echo json_encode($this->bpb_model->save_d());
    }

    public function delete_m()
    {
        $post = $this->input->post();
        $nomor = $post["nomor"];
        $nama = $post["nama"];
        $dika = '<div class="alert alert-success" role="alert">No Transaksi ' . $nomor . ', Nama : ' . $nama . ' Berhasil di Hapus!</div>';
        $this->db->where('id_bpb', $post['idd']);
        $this->db->delete('trans_bpb_d');
        $this->db->where('id_bpb', $post['idd']);
        $this->db->delete('trans_bpb');
        $this->session->set_flashdata('messagez', $dika);
        redirect('trans/bpb');
    }

    public function delete_d()
    {
        $post = $this->input->post();
        $this->db->where('id_detail', $post['idd']);
        $this->db->delete('trans_bpb_d');
        $id_transaksi =  $post['idt'];
        $url = 'trans/bpb/edit/' . $id_transaksi;
        redirect($url);
    }

    public function delete_gbr()
    {
        $post = $this->input->post();
        $this->db->where('id_transaksi', $post['idhd']);
        $this->db->delete('trans_bpb_d_gbr');
        $id_transaksi =  $post['idhm'];
        $url = 'trans/bpb/edit/' . $id_transaksi;
        redirect($url);
    }

    public function modal_view($id_transaksi)
    {
        $data['konfirmasi_m'] = $this->bpb_model->konfirmasi_m($id_transaksi);
        $data['konfirmasi_d'] = $this->bpb_model->konfirmasi_d($id_transaksi);
        $data['gbr'] = $this->bpb_model->gbr($id_transaksi);
        $this->load->view('trans/v_bpb_modal_view', $data);
    }
    public function update_m()
    {
        $this->bpb_model->update_m();
        $post = $this->input->post();
        $id_transaksi =  $post["txtid_transaksi"];
        $url = 'trans/bpb/edit/' . $id_transaksi;
        redirect($url);
    }

    public function pilihbarang($id_po)
    {
        //ini dipakai
        $query = "SELECT * FROM trans_po_d a
                    inner join m_barang b on a.id_barang = b.id_barang
                    inner join m_satuan c on a.id_satuan = c.id_satuan
        where id_transaksi = $id_po and jml_konv_terkecil >= jml_dt_konv_terkecil and (jml_konv_terkecil - jml_dt_konv_terkecil) <> 0 ";
        $data['barang'] = $this->db->query($query)->result_array();
        $this->load->view('trans/v_bpb_modal_barang', $data);
    }

    public function pilihsupplier()
    {
        $data['m_supplier'] = $this->db->get('m_supplier')->result_array();
        $this->load->view('trans/v_bpb_modal_supplier', $data);
    }

    public function pilihgudang($id_company)
    {
        $q = "select * from m_gudang where is_outstanding = 0 and id_company = $id_company
          ";
        $data['m_gudang'] = $this->db->query($q)->result_array();
        $this->load->view('trans/v_ajax_gudang', $data);
    }

    public function cetak($id_transaksi)
    {

        $rowf = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $id_user = $rowf['id'];

        $query = "select id_detail from trans_bpb_d where id_transaksi = $id_transaksi order by id_detail";
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
        $url = 'trans/bpb/cetak2/' . $id_transaksi;
        redirect($url);
    }
    public function cetak2($id_transaksi)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();
        $data['master'] = $this->bpb_model->cetak_m($id_transaksi);
        $data['detail'] = $this->bpb_model->konfirmasi_d($id_transaksi);

        $data['jenis'] = "po";



        $this->load->view('cetak/c_bpb', $data);
    }

    public function is_complete()
    {

        $id_bpb = $this->input->post('id');

        $data = [
            'id_bpb' => $id_bpb
        ];

        $result = $this->db->get_where('trans_bpb', $data);

        if ($result->num_rows() < 1) {
        } else {
            $result2 = $this->db->get_where('trans_bpb', $data)->row_array();
            if ($result2['is_complete'] == 1) {
                $this->is_complete = 0;
                $this->db->update("trans_bpb", $this, $data);
            } else {
                $this->is_complete = 1;
                $this->db->update("trans_bpb", $this, $data);
            }
        }
    }

    public function upload()
    {
        //$this->penawaran_model->update_m();
        $this->bpb_model->upload();
        $url = 'trans/bpb/edit/' . $this->input->post('txtid_transaksi');
        redirect($url);
    }
}
