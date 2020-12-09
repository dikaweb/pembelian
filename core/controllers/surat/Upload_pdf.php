<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PHPZxing\PHPZxingDecoder;

class upload_pdf extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index()
    {

        $data['title'] = 'Upload PDF';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $data['company'] = $this->db->get('surat')->result_array();


        //$data['lokasi'] = $this->db->get('lokasi')->result_array();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_upload_pdf', $data);
    }

    public function upload()
    {
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_departement = $row['id_dept'];
        $id_lokasi = $row['id_lokasi'];
        $id_user = $row['id'];
        $upload_image = $_FILES['image']['name'];

        if ($upload_image) {
            $config['allowed_types'] = 'pdf';
            $config['max_size']      = '12048';
            $config['upload_path'] = './assets/pdf_app';
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('image')) {
                $gbr = $this->upload->data();
                $lokasi_baru = './assets/pdf_app/';

                rename($gbr["full_path"], $lokasi_baru . $id_user . '.pdf');
                //$comando = '"C:\Program Files\LibreOffice\program\soffice.exe" --headless --convert-to jpg --outdir  ./assets/jpg_temp/ ' . $gbr["full_path"];
                $comando = 'sudo unoconv -o ./assets/jpg_temp/' . $id_user . ' -f jpg ' . './assets/pdf_app/' . $id_user . '.pdf';

                $var = exec($comando);

                $decoder        = new PHPZxingDecoder();
                $data           = $decoder->decode('./assets/jpg_temp/' . $id_user . '.jpg');
                if ($data->isFound()) {
                    $b = $data->getImageValue();

                    $b = str_replace("/", "#", $b);
                    $no_surat = $data->getImageValue();
                    $row1 = $this->db->get_where('surat', ['no_surat' => $no_surat]);
                    $rowcount = $row1->num_rows();
                    $row2 = $row1->row_array();
                    $id_trans = $row2['id_surat'];

                    if ($rowcount == 1) {
                        rename('./assets/pdf_app/' . $id_user . '.pdf', './assets/pdf_app/' . $b . '.pdf');
                        $this->db->query("update surat set is_pdf = 1 where no_surat = '$no_surat'");
                        redirect('surat/upload_pdf/sukses/' . $id_trans);
                    } else {
                        redirect('surat/upload_pdf/tampilpdfsalah/' . $id_user);
                    }
                } else {
                    redirect('surat/upload_pdf/tampilpdfsalah/' . $id_user);
                }
            } else {
                echo  $this->upload->display_errors('', '');
                die();
            }
        }

        redirect('surat/upload_pdf');
    }
    public function sukses($id_trans)
    {
        $data['title'] = 'Data berhasil di UPLOAD';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id = $id_trans;
        $data['surat'] =  $this->db->query("select * from surat a inner join lokasi b on a.id_lokasi = b.id inner join m_dept c on a.id_dept = c.id_dept where id_surat = $id")
            ->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_upload_pdf_sukses', $data);
        $this->load->view('templates/footer', $data);
    }

    public function tampilpdf($id_surat)
    {
        $row = $this->db->get_where('surat', ['id_surat' => $id_surat])->row_array();
        $id_user = $row['id_user'];
        $no_surat = $row['no_surat'];
        $no_surat_file = str_replace("/", "#", $no_surat);

        $data['filename'] = "./assets/pdf_app/" . $no_surat_file . ".pdf";
        $this->load->view('surat/v_tampilpdf', $data);
    }

    public function tampilpdfsalah($id_user)
    {
        $data['title'] = 'QRCODE tidak dapat di deteksi, silahkan pilih nomor manual';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $data['surat'] =  $this->db->query("select * from surat where is_pdf =0")
            ->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_upload_pdf_salah', $data);
        $this->load->view('templates/footer', $data);
    }
    public function showpdfsalah($id_surat)
    {
        $row = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_user = $row['id'];

        $data['filename'] = "./assets/pdf_app/" . $id_user . ".pdf";
        $this->load->view('surat/v_tampilpdf', $data);
    }

    public function update_nomor_salah()
    {
        $id_surat = $this->input->post('id_surat');
        $row = $this->db->get_where('surat', ['id_surat' => $id_surat])->row_array();
        $no_surat = $row['no_surat'];
        $no_surat_file = str_replace("/", "#", $no_surat);

        $row2 = $this->db->get_where('user', ['email' => $this->session->userdata('email2')])->row_array();
        $id_user = $row2['id'];

        rename('./assets/pdf_app/' . $id_user . '.pdf', './assets/pdf_app/' . $no_surat_file . '.pdf');
        $this->db->query("update surat set is_pdf = 1 where id_surat = '$id_surat'");
        redirect('surat/upload_pdf/sukses/' . $id_surat);
    }
}
