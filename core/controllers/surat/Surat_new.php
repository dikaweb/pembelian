<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Writer\Word2007;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use setasign\fpdi;
use ncjoes\OfficeConverter\OfficeConverter;

class Surat_new extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {
        $data['title'] = 'Tambah Surat';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $data['company'] = $this->db->get('m_company')->result_array();
        $data['dept'] = $this->db->get('m_dept')->result_array();

        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_user = $row['id'];
        $id_dept_user = $row['id_dept'];

        $query2 = $this->db->query("select count(id_user) as jml from surat where id_user = $id_user and is_pdf = 0");
        $row2 = $query2->row_array();
        $data['adabelumupload'] = $row2['jml'];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_surat_new', $data);
    }

    public function upload()
    {
        $data['title'] = 'New';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $data['company'] = $this->db->get('m_company')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_surat_new', $data);
        //$this->load->view('templates/footer', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id = $id;
        $data['surat'] =  $this->db->get_where('surat', ['id_surat' => $id])->row_array();

        $data['departement'] = $this->db->get('m_dept')->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_edit_surat', $data);
        $this->load->view('templates/footer', $data);
    }

    public function upload_doc()
    {
        $id_company = $this->input->post('nm_company');
        $tgl_upload = $this->input->POST('tgl');
        $id_dept = $this->input->POST('txt_dept');
        $id_kode_jenis_dept = $this->input->POST('txt_jenis_dept');

        //cek apakah surat yang dipilih jenis sekretaris
        $querya = $this->db->query("select id_dept from m_kode_jenis_dept where id_kode_jenis_dept = $id_kode_jenis_dept");
        $rowa = $querya->row_array();
        //jika surat yang dipilih jenis sekretaris
        if ($rowa['id_dept'] == 12) {
            $id_dept = 12;
        }

        $query = $this->db->query("select * from m_kode where id_dept = $id_dept and id_company = $id_company");
        $row1 = $query->row_array();
        $adakode = count($row1);
        if ($adakode == 0) {
            var_dump($id_dept);
            var_dump($id_company);
            var_dump('Kode departement dan company belum ada');
            die();
        }

        $id_kode = $row1['id_kode'];
        //var_dump($id_kode_jenis_dept);
        // die();
        $no_surat = "";
        $query = $this->db->query("select * from m_kode_d where id_kode = $id_kode order by no_urut");
        foreach ($query->result() as $row3) {
            $kode_tipe = $row3->id_kode_tipe;
            if ($kode_tipe == 1) {
                $tahun = date('Y', strtotime($tgl_upload));

                $query = $this->db->query("select no_urut as max_id,id_surat from surat where no_urut = (SELECT MAX(no_urut) FROM surat where tahun = $tahun and id_company = $id_company and id_dept = $id_dept)");
                $row = $query->row_array();
                $no_urut = $row['max_id'] + 1;


                $mulai = $row['max_id'] - 10;
                $this->db->select('no_urut');
                $this->db->order_by('no_urut');
                $query = $this->db->query("select no_urut from surat where no_urut > $mulai and tahun = $tahun and id_company = $id_company and id_dept = $id_dept order by no_urut");
                $arr1 =  $query->result_array();
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
                $no_surat = $no_surat . sprintf("%03s", $no_urut);
            }

            if ($kode_tipe == 2) {
                $query = $this->db->query("select kode_c from m_company where id_company = $id_company");
                $row4 = $query->row_array();
                $no_surat = $no_surat . $row4['kode_c'];
            }
            if ($kode_tipe == 3) {
                $query2 = $this->db->query("select bulan_romawi('$tgl_upload') as tes");
                $row6 = $query2->row_array();
                $no_surat = $no_surat . $row6['tes'];
            }
            if ($kode_tipe == 4) {
                $query = $this->db->query("select kode_d from m_dept where id_dept = $id_dept");
                $row6 = $query->row_array();
                $no_surat = $no_surat . $row6['kode_d'];
            }
            if ($kode_tipe == 5) {
                $query3 = $this->db->query("select tahun_4_digit('$tgl_upload') as tes2");
                $row7 = $query3->row_array();
                $no_surat = $no_surat . $row7['tes2'];
            }
            if ($kode_tipe == 6) {
                $query4 = $this->db->query("select nm_kode_jenis_dept from m_kode_jenis_dept where id_kode_jenis_dept = $id_kode_jenis_dept");
                $row8 = $query4->row_array();
                $no_surat = $no_surat . $row8['nm_kode_jenis_dept'];
            }
            if ($kode_tipe == 7) {
                $no_surat = $no_surat . "/";
            }
            if ($kode_tipe == 8) {
                $no_surat = $no_surat . ".";
            }
            if ($kode_tipe == 9) {
                $no_surat = $no_surat . "-";
            }
        }


        $this->db->reset_query();
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_departement = $row['id_dept'];
        $id_lokasi = $row['id_lokasi'];
        $id_user = $row['id'];
        $my_date = date("Y-m-d H:i:s");

        $no_surat_file = str_replace("/", "#", $no_surat);

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'docx';
            $config['max_size']      = '2048';
            $config['upload_path'] = './assets/docx';
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('image')) {
                $gbr = $this->upload->data();
                $lokasi_baru = './assets/docx/';
                $namabaru = $no_surat_file . '.docx';
                rename($gbr["full_path"], $lokasi_baru . $namabaru);

                //////-------------convert ke txt masukkan ke database
                //$comando2 = '"C:\Program Files\LibreOffice\program\soffice.exe" --headless --convert-to txt:"Text" --outdir  ./assets/pdf/ ./assets/docx/' . $namabaru;

                $comando2 = 'sudo unoconv -o ./assets/pdf/'  . $no_surat_file . '.txt -f txt ./assets/docx/' . $namabaru;

                $var2 = exec($comando2);

                $lines = file_get_contents('./assets/pdf/'  . $no_surat_file . '.txt');
                $lines = strtolower($lines);
                //$lines = preg_split('/\n|\r\n?|\t/', $lines);
                //$lines = implode(' ', $lines);
                //$lines = explode(' ', $lines);
                //$lines2 = strtolower($no_surat) . " " . implode(' ', $lines);
                //$lines = array_unique($lines);
                $lines = strtolower($no_surat) . " " . $lines;

                //$this->db->query("update surat set isi_surat = '$lines',is_doc = 1 where id_surat = $id_surat");
                //var_dump($id_kode_jenis_dept);

                $surat = [
                    'id_dept' => $id_dept,
                    'tgl_created' => $my_date,
                    'status' => 1,
                    'judul_surat' => $this->input->post('judul'),
                    'id_lokasi' => $id_lokasi,
                    'id_user' => $id_user,
                    'id_kode_jenis_dept' => $id_kode_jenis_dept,
                    'no_surat' => $no_surat,
                    'isi_surat' => $lines,
                    'no_urut' => $no_urut,
                    'tahun' => $tahun,
                    'id_company' => $id_company,
                    'tgl_upload' => $tgl_upload
                ];

                $this->db->insert('surat', $surat);
                rename('./assets/pdf/' . $no_surat_file . '.txt', './assets/pdf/' . $id_user . '.txt');
            } else {
                echo  $this->upload->display_errors('', '');
                die();
            }
        } else {
            $this->session->set_flashdata('message', "Tidak ada file yang di upload, silahkan pilih file ..");
            redirect('surat/surat_new/');
        }


        $query = $this->db->query("select id_surat,no_surat from surat where id_surat = (select max(id_surat) as id_surat from surat)");
        $row4 = $query->row_array();
        $id_surat = $row4['id_surat'];


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

        $image_name = $no_surat_file . '.png'; //buat name dari qr code sesuai dengan nim
        $params['data'] = $no_surat; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        redirect('surat/surat_new/edit/' . $id_surat);
    }

    public function update_surat()
    {
        ////----- get file yg mau di rubah
        $row = $this->db->get_where('surat', ['id_surat' => $this->input->post('txtid_transaksi')])->row_array();
        $id_user = $row['id_user'];
        $id_surat = $row['id_surat'];
        $no_surat = $row['no_surat'];
        $id_dept = $row['id_dept'];
        $id_company = $row['id_company'];
        $tgl_upload = $row['tgl_upload'];
        $id_kode_jenis_dept = $row['id_kode_jenis_dept'];
        $no_surat_file = str_replace("/", "#", $no_surat);

        ////-----get post dari form edit
        $no_urut = $this->input->post('no_urut');



        ///ini adalah pembuatan nomor ulang setelah no urut berubah
        $queryb = $this->db->query("select * from m_kode where id_dept = $id_dept and id_company = $id_company");
        $rowb = $queryb->row_array();
        $id_kode = $rowb['id_kode'];



        $no_surat = "";
        $query = $this->db->query("select * from m_kode_d where id_kode = $id_kode order by no_urut");
        foreach ($query->result() as $row3) {
            $kode_tipe = $row3->id_kode_tipe;
            if ($kode_tipe == 1) {
                $no_surat = $no_surat . sprintf("%03s", $no_urut);
            }

            if ($kode_tipe == 2) {
                $query = $this->db->query("select kode_c from m_company where id_company = $id_company");
                $row4 = $query->row_array();
                $no_surat = $no_surat . $row4['kode_c'];
            }
            if ($kode_tipe == 3) {
                $query2 = $this->db->query("select bulan_romawi('$tgl_upload') as tes");
                $row6 = $query2->row_array();
                $no_surat = $no_surat . $row6['tes'];
            }
            if ($kode_tipe == 4) {
                $query = $this->db->query("select kode_d from m_dept where id_dept = $id_dept");
                $row6 = $query->row_array();
                $no_surat = $no_surat . $row6['kode_d'];
            }
            if ($kode_tipe == 5) {
                $query3 = $this->db->query("select tahun_4_digit('$tgl_upload') as tes2");
                $row7 = $query3->row_array();
                $no_surat = $no_surat . $row7['tes2'];
            }
            if ($kode_tipe == 6) {
                $query4 = $this->db->query("select nm_kode_jenis_dept from m_kode_jenis_dept where id_kode_jenis_dept = $id_kode_jenis_dept");
                $row8 = $query4->row_array();
                $no_surat = $no_surat . $row8['nm_kode_jenis_dept'];
            }
            if ($kode_tipe == 7) {
                $no_surat = $no_surat . "/";
            }
            if ($kode_tipe == 8) {
                $no_surat = $no_surat . ".";
            }
            if ($kode_tipe == 9) {
                $no_surat = $no_surat . "-";
            }
        }
        // end pembuatan nomor ulang setelah no urut baru dirubah



        //// cocokan apakah terdapat perubahan nomor dari file yg mau di rubah dg data dari post
        $c_surat = $this->input->post('no2');
        $c_surat_file = str_replace("/", "#", $no_surat);

        if ($no_surat != $c_surat) {
            $a = $this->db->query("select count(id_surat) as jml from surat where no_surat = '$no_surat'")->row_array();
            $b = $a['jml'];
            if ($b > 0) { ///---- jika ternyata nomor baru yg dirubah sudah ada di database
                var_dump($a);
                var_dump($c_surat);
                var_dump("Nomor sudah ada");
                die();
                redirect('surat/surat_new/edit/' . $this->input->post('txtid_transaksi'));
            }
        };


        //rename nama file lama ke nama file baru
        rename('./assets/docx/' . $no_surat_file . '.docx', './assets/docx/' . $c_surat_file . '.docx');

        var_dump($no_surat_file);
        var_dump($c_surat_file);
        //die();

        $id = $this->input->post('txtid_transaksi');
        $this->judul_surat = $this->input->post('judul');
        // $this->id_dept = $this->input->post('nm_dept');
        // $this->id_lokasi = $this->input->post('nm_lokasi');
        $this->no_surat = $no_surat;
        $this->no_urut = trim($this->input->post('no_urut'));
        $this->db->where('id_surat', $id);
        $this->db->update('surat', $this);

        //untuk file
        $no_surat_file = str_replace("/", "#", $c_surat_file);
        $no_surat = str_replace("#", "/", $c_surat_file);



        $namabaru = $no_surat_file . '.docx';

        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'docx';
            $config['max_size']      = '2048';
            $config['upload_path'] = './assets/docx';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $gbr = $this->upload->data();
                $lokasi_baru = './assets/docx/';


                rename($gbr["full_path"], $lokasi_baru . $namabaru);
            } else {
                echo  $this->upload->display_errors('', '');
                die();
            }
        }

        /////////////////----------------conver txt masukkan ke database
        //$comando2 = '"C:\Program Files\LibreOffice\program\soffice.exe" --headless --convert-to txt:"Text" --outdir  ./assets/pdf/ ./assets/docx/' . $namabaru;

        $comando2 = 'sudo unoconv -o ./assets/pdf/'  . $no_surat_file . '.txt -f txt ./assets/docx/' . $namabaru;


        $var2 = exec($comando2);


        $lines = file_get_contents('./assets/pdf/'  . $no_surat_file . '.txt');
        $lines = strtolower($lines);

        $lines = strtolower($no_surat) . " " . strtolower($this->input->post('judul')) . " " .  $lines;
        $this->db->query("update surat set isi_surat = '$lines' where id_surat = $id_surat");
        rename('./assets/pdf/' . $no_surat_file . '.txt', './assets/pdf/' . $id_user . '.txt');

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

        $image_name = $no_surat_file . '.png'; //buat name dari qr code sesuai dengan nim
        $params['data'] = $no_surat; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

        redirect('surat/surat_new/edit/' . $this->input->post('txtid_transaksi'));
    }

    public function tampilpdf2($id_surat)
    {

        $row = $this->db->get_where('surat', ['id_surat' => $id_surat])->row_array();
        $id_user = $row['id_user'];
        $no_surat = $row['no_surat'];
        $no_surat_file = str_replace("/", "#", $no_surat);

        ///////////////////////////////////////////
        $namabaru = $no_surat_file . '.docx';

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('./assets/docx/' . $namabaru);
        //$templateProcessor->setImageValue('ttd', array('path' => './images/stempel2.png', 'width' => 90, 'height' => 100, 'ratio' => false));
        $templateProcessor->setImageValue('qrcode', array('path' => './assets/img/qrcode/' . $no_surat_file . '.png', 'width' => 85, 'height' => 85, 'ratio' => false));
        $templateProcessor->setImageValue('kop', array('path' => './images/kopsurat.jpg', 'width' => 900, 'ratio' => true));
        $templateProcessor->setValue('no_surat', $no_surat);
        $templateProcessor->saveAs("./assets/docx_temp/" . $id_user . ".docx");
        //$comando = '"C:\Program Files\LibreOffice\program\soffice.exe" --headless --convert-to pdf:writer_pdf_Export --outdir  ./assets/pdf/ ./assets/docx_temp/' . $id_user . '.docx';
        $comando = 'sudo unoconv -o ./assets/pdf/' . $id_user . ' -f pdf ./assets/docx_temp/' . $id_user . '.docx';
        $var = exec($comando, $output);

        $data['filename'] = "./assets/pdf/" . $id_user . ".pdf";
        $this->load->view('surat/v_tampilpdf', $data);
    }


    public function cek_ada_jenis_surat()
    {
        $id_dept = $this->input->post('id_dept');
        //$id_dept = 13;
        $id_company = 2;
        $query = $this->db->query("SELECT count(id_dept) as jml from m_kode_jenis_dept where id_dept = $id_dept and id_company = $id_company");
        $row = $query->row_array();
        $jumlah = $row['jml'];

        $id_login = $this->session->userdata('id_login2');
        $query2 = $this->db->query("SELECT is_secretary from user where id = $id_login ");
        $row2 = $query2->row_array();
        // $jumlah = 'test';
        $jumlah = $jumlah + $row2['is_secretary'];
        echo json_encode($jumlah);
    }

    public function cbo_jenis_surat($id_dept, $id_company)
    {
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $is_secretary = $row['is_secretary'];
        if ($is_secretary == 0) {
            $data['dept'] = $this->db->query("select * from m_kode_jenis_dept where id_dept = $id_dept and id_company = $id_company")->result_array();
        } else {
            $data['dept'] = $this->db->query("select * from m_kode_jenis_dept where id_dept = $id_dept and id_company = $id_company union all select * from m_kode_jenis_dept where id_dept = 12 and id_company = $id_company ")->result_array();
        }
        $this->load->view('surat/v_surat_new_cbo_jenis_surat', $data);
    }
}
