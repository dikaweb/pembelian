<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_role_model extends CI_Model
{
    private $nm_table = "user";

    public function rules()
    {
        return [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'trim|required'
            ]
        ];
    }
    public function getSubMenu()
    {
        $query = "SELECT a.username as email, a.nama_lengkap as name, b.role as role, a.id as id,b.id as id_role
                  ,c.lokasi as lokasi
                  FROM user a 
                  JOIN user_role b ON a.role_id = b.id 
                  left JOIN lokasi c ON a.lokasi_id = c.id 
                ";
        return $this->db->query($query)->result_array();
    }

    public function cbo_role()
    {
        return $this->db->get('user_role')->result_array();
    }
    public function cbo_lokasi()
    {
        return $this->db->get('lokasi')->result_array();
    }


    public function getSubMenubyid($id)
    {
        $query = "SELECT a.username as email, a.nama_lengkap as name, b.id as id_role, a.id as id_user
                  ,a.lokasi_id as id_lokasi
                  FROM user a 
                  JOIN user_role b ON a.role_id = b.id where a.id = $id
                ";
        return $this->db->query($query)->row_array();
    }

    public function update_user_role()
    {
        $post = $this->input->post();
        $this->id = $post["id"];
        $this->nama_lengkap = $post["name"];
        $this->username = $post["email"];
        $this->role_id = $post["role"];
        $this->lokasi_id = $post["lokasi"];


        $this->db->update($this->nm_table, $this, array('id' => $post['id']));
    }
}
