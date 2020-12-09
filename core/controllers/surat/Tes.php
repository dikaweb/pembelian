<?php

use FontLib\Table\Type\post;

defined('BASEPATH') or exit('No direct script access allowed');

class tes extends CI_Controller
{



    public function index()
    {
        $data['title'] = 'Teees';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //$serial =  shell_exec('wmic diskdrive get serialnumber');

        //echo $serial;
        //echo "tesing";


        //var_dump($serial);
        //die();



        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('surat/v_tes', $data);
    }
}
