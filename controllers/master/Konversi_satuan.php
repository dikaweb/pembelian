<?php
defined('BASEPATH') or exit('No direct script access allowed');

class konversi_satuan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Konversi Satuan';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        $data['menu'] = $this->db->query('select * from m_barang a inner join m_satuan b on a.id_satuan = b.id_satuan')->result_array();



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/v_konversi_satuan', $data);
        $this->load->view('templates/footer');
    }

    public function edit($id_barang)
    {
        $data['title'] = 'Konversi Satuan';
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('usernamez')])->row_array();

        $data['data_m'] = $this->db->query("select * from m_barang a inner join m_satuan b on a.id_satuan = b.id_satuan where id_barang = $id_barang")->row_array();
        $data['data_d'] = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang order by no_urut")->result_array();
        $data['m_satuan'] = $this->db->get("m_satuan")->result_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('master/v_konversi_satuan_edit', $data);
        $this->load->view('templates/footer');
    }
    public function delete()
    {
        //cari di tabel po_d apakah ada satuan ini
        $id = $this->input->post('idd');
        $id_barang = $this->input->post('id_barang');

        //$row = $this->db->query("select * from m_barang where id_barang = $id_barang")->row_array();
        //$sat_asli = $row['id_satuan'];
        //$id_to = $this->input->post('id_sat_to');
        //echo "to awal: " . $id_to . "<br>";
        //akal-akalan ae
        //if ($id_to == $sat_asli) {
        //    $id_to = $this->input->post('id_sat_from');
        //}
        //echo "to kemudian: " . $id_to . "<br>";
        //$id_from = $this->input->post('id_sat_from');
        //echo "from awal: " . $id_from . "<br>";
        //if ($id_from == $sat_asli) {
        //    $id_from = $this->input->post('id_sat_to');
        //}
        //echo "from kemudian: " . $id_from . "<br>";
        $id_to = $this->input->post('id_sat_to');
        $id_from = $this->input->post('id_sat_from');
        $ada_po_d = $this->db->query("select * from trans_po_d where id_barang=$id_barang and (id_satuan = $id_to or id_satuan = $id_from)")->num_rows();
        if ($ada_po_d > 0) {
            echo "tidak bisa dihapus karena satuan sudah dipakai di pre order / PO";
            die();
        }
        $ada_bpb_d = $this->db->query("select * from trans_bpb_d where id_barang=$id_barang and (id_satuan = $id_to or id_satuan = $id_from)")->num_rows();
        if ($ada_bpb_d > 0) {
            echo "tidak bisa dihapus karena satuan sudah dipakai di Penerimaan barang";
            die();
        }

        $this->db->delete('m_satuan_konversi', array('id' => $id));
        $rw = $this->db->query("select cari_satuan_terkecil($id_barang) as kecil from dual")->row_array();
        $kecil = $rw['kecil'];
        $this->db->query("update m_barang set id_satuan = $kecil where id_barang = $id_barang");
        redirect('master/konversi_satuan/edit/' . $this->input->post('id_barang'));
    }
    public function save()
    {
        $id_barang = $this->input->post('txtid_barang');
        $cbo_from = $this->input->post('cbofrom');
        $cbo_to = $this->input->post('cboto');
        $ada = 0;
        $sdh_ada_konversi = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang")->num_rows();
        if ($sdh_ada_konversi == 0) {
            $row = $this->db->query("select * from m_barang where id_barang = $id_barang")->row_array();
            $sat_asli = $row['id_satuan'];
            if (($cbo_from == $sat_asli) || ($cbo_to == $sat_asli)) {
            } else {
                echo "Salah satu dari satuan atau ke satuan harus ada nilai satuan terkecil";
                die();
            }
        } else {
            $tenanada = $this->db->query("select * from m_satuan_konversi where id_barang = $id_barang
            and (from_satuan = $cbo_from or to_satuan = $cbo_from or to_satuan = $cbo_to or from_satuan = $cbo_to)
            ")->num_rows();
            if ($tenanada == 0) {
                echo "Salah satu dari satuan atau ke satuan harus ada nilai dari konversi sebelumnya";
                die();
            }
        }

        //var_dump($tenanada);
        //var_dump($this->db->query("select * from m_satuan_konversi where id_barang = $id_barang
        //and (from_satuan = $cbo_from or to_satuan = $cbo_from or to_satuan = $cbo_to or from_satuan = $cbo_to)
        //")->row_array());
        //die();

        $this->id_barang = trim(htmlspecialchars($this->input->post('txtid_barang')));
        $this->from_satuan = trim(htmlspecialchars($this->input->post('cbofrom')));
        $this->nilai = trim(htmlspecialchars($this->input->post('txtnilai')));
        $this->to_satuan = trim(htmlspecialchars($this->input->post('cboto')));
        $this->no_urut = trim(htmlspecialchars($this->input->post('txtno_urut')));
        $this->db->insert('m_satuan_konversi', $this);

        $rw = $this->db->query("select cari_satuan_terkecil($id_barang) as kecil from dual")->row_array();
        $kecil = $rw['kecil'];
        $this->db->query("update m_barang set id_satuan = $kecil where id_barang = $id_barang");
        redirect('master/konversi_satuan/edit/' . $this->input->post('txtid_barang'));
    }
}
