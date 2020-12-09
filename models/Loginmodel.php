<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Loginmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function is_valid($username)
    {
        $this->db->select('*');
        $this->db->from('user_trans');
        $this->db->where('email', $username);
        $query = $this->db->get();
        return $query->row();
    }
    public function is_valid_num($username)
    {
        $this->db->select('*');
        $this->db->from('user_trans');
        $this->db->where('email', $username);
        $query = $this->db->get();
        return $query->num_rows();
    }
}
