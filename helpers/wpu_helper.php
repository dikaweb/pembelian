<?php

function is_logged_in()
{
    //die();
    $ci = get_instance();
    if (!$ci->session->userdata('usernamez')) {
        redirect('auth');
    } else {
        $seg = $ci->uri->segment(2);
        if ($seg == NULL) {
            $role_id = $ci->session->userdata('role_idz');
            $menu = $ci->uri->segment(1);

            $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
            $menu_id = $queryMenu['id'];

            $userAccess = $ci->db->get_where('user_access_menu', [
                'role_id' => $role_id,
                'menu_id' => $menu_id
            ]);

            if ($userAccess->num_rows() < 1) {
                redirect('auth/blocked');
            }
        } else {

            $role_id = $ci->session->userdata('role_idz');
            $sub_menu = $ci->uri->segment(1) . "/" . $ci->uri->segment(2);
            $queryMenu = $ci->db->get_where('user_sub_menu', ['url' => $sub_menu])->row_array();
            $menu_id = $queryMenu['id'];

            $userAccess = $ci->db->get_where('user_access_menu', [
                'role_id' => $role_id,
                'sub_menu_id' => $menu_id
            ]);


            if ($userAccess->num_rows() < 1) {
                redirect('auth/blocked');
            }

            $readonly = $ci->db->get_where('user_access_menu', [
                'role_id' => $role_id,
                'sub_menu_id' => $menu_id
            ])->row_array();
            $ci->session->set_flashdata('ro',  $readonly['ro']);
            $ci->session->set_flashdata('v_all',  $readonly['v_all']);
            $ci->session->set_flashdata('v_all_lokasi',  $readonly['v_all_lokasi']);
            $ci->session->set_flashdata('v_all_dept',  $readonly['v_all_dept']);
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_sub_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_g_lokasi($id_company, $id_lokasi)
{
    $ci = get_instance();

    $ci->db->where('id_company', $id_company);
    $ci->db->where('id_lokasi', $id_lokasi);
    $result = $ci->db->get('m_gudang');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_read_only($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu')->row_array();

    if ($result['ro'] == 1) {
        return "checked='checked'";
    }
}

function check_view_all($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu')->row_array();

    if ($result['v_all'] == 1) {
        return "checked='checked'";
    }
}

function check_view_all_dept($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu')->row_array();

    if ($result['v_all_dept'] == 1) {
        return "checked='checked'";
    }
}

function check_view_all_lokasi($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('sub_menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu')->row_array();

    if ($result['v_all_lokasi'] == 1) {
        return "checked='checked'";
    }
}
function check_bpb_is_complete($id_bpb)
{
    $ci = get_instance();
    $ci->db->where('id_bpb', $id_bpb);
    $result = $ci->db->get('trans_bpb')->row_array();
    if ($result['is_complete'] == 1) {
        return "checked='checked'";
    }
}


function rupiah($angka)
{
    $sub_kalimat = substr($angka, -3);
    if ($sub_kalimat == ".00") {
        $hasil_rupiah = number_format($angka, 0, ',', '.');
    } else {
        $hasil_rupiah =  number_format($angka, 2, ',', '.');
    }
    return $hasil_rupiah;
}

function qtyrp($angka)
{
    $sub_kalimat = substr($angka, -3);
    if ($sub_kalimat == ".00") {
        $hasil_rupiah = number_format($angka, 0, '.', ',');
    } else {
        $hasil_rupiah =  number_format($angka, 2, '.', ',');
    }
    return $hasil_rupiah;
}


function rp($angka)
{
    $hasil_rupiah = number_format($angka, 0, '.', ',');
    return $hasil_rupiah;
}

function tgl_indo($tanggal)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}

function tgl_indo2($tanggal)
{
    $bulan = array(
        1 =>   'Jan',
        'Feb',
        'Maret',
        'Apr',
        'Mei',
        'Juni',
        'Juli',
        'Agust',
        'Sept',
        'Okt',
        'Nov',
        'Des'
    );
    $pecahkan = explode('-', $tanggal);

    // variabel pecahkan 0 = tanggal
    // variabel pecahkan 1 = bulan
    // variabel pecahkan 2 = tahun

    return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = ucfirst(trim(penyebut($nilai)));
    }
    return $hasil;
}


function findMissing($arr, $n)
{
    $l = 0;
    $h = $n - 1;

    while ($h > $l) {

        $mid = floor($l + ($h - $l) / 2);

        // Check if middle element is consistent  
        if ($arr[$mid] - $mid == $arr[0]) {

            // No inconsistency till middle elements  
            // When missing element is just after  
            // the middle element  
            if ($arr[$mid + 1] - $arr[$mid] > 1)
                return $arr[$mid] + 1;
            else {

                // Move right  
                $l = $mid + 1;
            }
        } else {

            // Inconsistency found  
            // When missing element is just before  
            // the middle element  
            if ($arr[$mid] - $arr[$mid - 1] > 1)
                return $arr[$mid] - 1;
            else {

                // Move left  
                $h = $mid - 1;
            }
        }
    }

    // No missing element found  
    return 0;
}
