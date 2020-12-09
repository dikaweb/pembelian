<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;
use \Firebase\JWT\JWT;

class Rest extends RestController
{
    private $secretkey = 'kode_rahasia_kamu'; //ubah dengan kode rahasia apapun
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    // method untuk melihat token pada user
    public function generate_post()
    {
        $this->load->model('loginmodel');
        $date = new DateTime();
        $username = $this->post('username', TRUE); //ini adalah kolom username pada database yang saya berinama username.
        $pass = $this->post('password', TRUE); //ini adalah kolom password pada database yang saya berinama password.
        $dataadmin = $this->loginmodel->is_valid($username);
        if ($dataadmin) {
            if (password_verify($pass, $dataadmin->password)) {
                $payload['id'] = $dataadmin->id;
                $payload['username'] = $dataadmin->email;
                $payload['iat'] = $date->getTimestamp(); //waktu di buat
                $payload['exp'] = $date->getTimestamp() + 3600; //satu jam
                $output['id'] = $dataadmin->id;
                $output['username'] = $dataadmin->email;
                $output['token'] = JWT::encode($payload, $this->secretkey);
                return $this->response($output, RESTController::HTTP_OK);
            } else {
                $this->viewtokenfail($username);
            }
        } else {
            $this->viewtokenfail($username);
        }
    }
    // method untuk jika generate token diatas salah
    public function viewtokenfail($username)
    {
        $this->response([
            'status' => FALSE,
            'username' => $username,
            'message' => 'Invalid!'
        ], RESTController::HTTP_BAD_REQUEST);
    }
    // method untuk mengecek token setiap melakukan post, put, etc
    public function cektoken()
    {
        $this->load->model('loginmodel');
        $jwt = $this->input->get_request_header('Authorization');
        try {
            $decode = JWT::decode($jwt, $this->secretkey, array('HS256'));
            if ($this->loginmodel->is_valid_num($decode->username) > 0) {
                return true;
            }
        } catch (Exception $e) {
            exit('Wrong Token' . $jwt);
        }
    }
}
