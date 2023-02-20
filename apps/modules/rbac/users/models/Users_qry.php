<?php

/*
 * ***************************************************************
 *  Script : 
 *  Version : 
 *  Date :
 *  Author : Pudyasto Adi W.
 *  Email : mr.pudyasto@gmail.com
 *  Description : 
 * ***************************************************************
 */

/**
 * Description of Users_qry
 *
 * @author adi
 */
class Users_qry extends CI_Model {

    //put your code here
    protected $res = "";
    protected $delete = "";
    protected $state = "";

    public function __construct() {
        parent::__construct();
    }
    
    public function ref_mstunit() {
        $this->db->order_by('nama','ASC');
        $query = $this->db->get('m_unit');
        return $query->result_array();
    }
    
    public function ref_mstgroup() {
        $this->db->order_by('name','ASC');
        $query = $this->db->get('groups');
        return $query->result_array();
    }
    
    
    public function select_data($param) {
        $str = "SELECT users.id
                        , users.ip_address
                        , users.username
                        , users.email
                        , users.full_name
                        , users_groups.group_id
                        , users.active
                        , users.unit_id
                      FROM users
                        LEFT JOIN users_groups
                            ON users_groups.user_id = users.id
                      WHERE users.id='".$param."'";
        $query = $this->db->query($str);
        return $query->result_array();
    }

    public function submit() {
        try {
            $array = $this->input->post();
            if (empty($array['id'])) {
                    $username = $this->input->post('username');
                    $password = $this->input->post('password_confirm');
                    $email = $this->input->post('email');
                    $additional_data = array(
                                            'full_name' => $this->input->post('full_name'),
                                            'unit_id' => ($this->input->post('unit_id')) ? $this->input->post('unit_id') : null,
                                            );
                    $group_id =  $this->input->post('group_id');
                    $group = array($group_id); // Sets user to admin.
                    $resl = $this->ion_auth->register($username, $password, $email, $additional_data, $group); 
                if (!$resl) {
                    $this->title = "Kesalahan";
                    $this->msg = $this->ion_auth->errors();
                    $this->state = "0";
                } else {
                    $this->title = "Berhasil";
                    $this->msg = "Data Berhasil Disimpan";
                    $this->state = "1";
                }
            } 
            elseif (!empty($array['id']) && empty($array['stat'])) {
                    if($array['id']=="1"){
                        throw new Exception("Kesalahan : Data pengguna administrator tidak boleh diubah!");
                    }
                    $password = $this->input->post('password_confirm');
                    $user_id = $this->input->post('id');
                    $data = array(
                        'full_name' => $this->input->post('full_name'),
                        'unit_id' => ($this->input->post('unit_id')) ? $this->input->post('unit_id') : null,
                        'username' => $this->input->post('username'),
                        'email' => $this->input->post('email'),
                        'active' => $this->input->post('active'),
                        'password' => $this->input->post('password_confirm'),
                    );  
                    $group_id =  $this->input->post('group_id');
                    $this->ion_auth->remove_from_group(NULL, $user_id);
                    $this->ion_auth->add_to_group($group_id, $user_id);
                    $resl = $this->ion_auth->update($user_id, $data);
                if (!$resl) {
                    $this->title = "Kesalahan";
                    $this->msg = $this->ion_auth->errors();
                    $this->state = "0";
                } else {
                    $this->title = "Berhasil";
                    $this->msg = "Data Berhasil Diupdate";
                    $this->state = "1";
                }
            } elseif (!empty($array['id']) && ($array['stat']=="delete")) {
                if($array['id']=="1"){
                    throw new Exception("Kesalahan : Data pengguna administrator tidak boleh dihapus!");
                }
                $resl = $this->ion_auth->delete_user($array['id']);
                if (!$resl) {
                    $this->title = "Kesalahan";
                    $this->msg = $this->ion_auth->errors();
                    $this->state = "0";
                } else {
                    $this->title = "Berhasil";
                    $this->msg = "Data Berhasil Dihapus";
                    $this->state = "1";
                }
            } elseif (!empty($array['id']) && ($array['stat']=="deleteall")) {
                $this->db->trans_begin();
                foreach ($array['id'] as $value) {
                    
                    if($value=="1"){
                        throw new Exception("Kesalahan : Data pengguna administrator tidak boleh dihapus!");
                    }
                    $resl = $this->ion_auth->delete_user($value);
                    if (!$resl) {
                        $this->db->trans_rollback();
                        $err = $this->db->error();
                        throw new Exception($this->apps->err_code($err['message']));
                    }
                }
                $this->db->trans_commit();
                $this->title = "Berhasil";
                $this->msg = "Data Berhasil Dihapus";
                $this->state = "1";
            } else {
                $this->title = "Kesalahan";
                $this->msg = "Variabel Tidak Sesuai";
                $this->state = "0";
            }
        } catch (Exception $e) {
            $this->title = "Kesalahan";
            $this->msg = $e->getMessage();
            $this->state = "0";
        }
        
        $arr = array(
            'title' => $this->title,
            'msg' => $this->msg,
            'state' => $this->state,
            'csrf_return' => $this->security->get_csrf_hash(),
        );
        return json_encode($arr);
    }
}
