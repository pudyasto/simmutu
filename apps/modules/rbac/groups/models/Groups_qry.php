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
 * Description of Groups_qry
 *
 * @author adi
 */
class Groups_qry extends CI_Model {

    //put your code here
    protected $res = "";
    protected $delete = "";
    protected $state = "";

    public function __construct() {
        parent::__construct();
    }
    
    public function select_data($param) {
        $this->db->where('id', $param);
        $query = $this->db->get('groups');
        return $query->result_array();
    }

    public function submit() {
        try {
            $array = $this->input->post();
            if (empty($array['id'])) {
                unset($array['id']);
                $resl = $this->db->insert('groups', $array);
                if (!$resl) {
                    $err = $this->db->error();
                    $this->title = "Kesalahan";
                    $this->msg = " Kesalahan : " . $this->apps->err_code($err['message']);
                    $this->state = "0";
                } else {
                    $this->title = "Berhasil";
                    $this->msg = "Data Berhasil Disimpan";
                    $this->state = "1";
                }
            } elseif (!empty($array['id']) && empty($array['stat'])) {
                $this->db->where('id', $array['id']);
                $resl = $this->db->update('groups', $array);
                if (!$resl) {
                    $err = $this->db->error();
                    $this->title = "Kesalahan";
                    $this->msg = " Kesalahan : " . $this->apps->err_code($err['message']);
                    $this->state = "0";
                } else {
                    $this->title = "Berhasil";
                    $this->msg = "Data Berhasil Diupdate";
                    $this->state = "1";
                }
            } elseif (!empty($array['id']) && ($array['stat']=="delete")) {
                $this->db->where('id', $array['id']);
                $resl = $this->db->delete('groups');
                if (!$resl) {
                    $err = $this->db->error();
                    $this->title = "Kesalahan";
                    $this->msg = " Kesalahan : " . $this->apps->err_code($err['message']);
                    $this->state = "0";
                } else {
                    $this->title = "Berhasil";
                    $this->msg = "Data Berhasil Dihapus";
                    $this->state = "1";
                }
            } elseif (!empty($array['id']) && ($array['stat']=="deleteall")) {
                $this->db->trans_begin();
                foreach ($array['id'] as $value) {
                    $this->db->where('id', $value);
                    $resl = $this->db->delete('groups');
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

    public function submit_group_access() {
        try {
            $group_id = $this->input->post('group_id');
            $menu_id = $this->input->post('menu_id');
            $privilege = $this->input->post('privilege');
            $stat = $this->input->post('stat');
            if($stat=='submenu'){
                $this->db->where("group_id",$group_id);
                $this->db->where("menu_id",$menu_id);
                $qrycek = $this->db->get("groups_access");
                if(!empty($qrycek->result_array())){
                    $str = "DELETE FROM groups_access WHERE group_id = '".$group_id."' AND menu_id = '".$menu_id."';";
                }else{
                    $str = "INSERT INTO groups_access
                                       (group_id
                                       ,menu_id
                                       ,privilege)
                             VALUES
                                       ('".$group_id."'
                                       ,'".$menu_id."'
                                       ,'".$privilege."');";
                }
            }else{
                $str = "DELETE FROM groups_access WHERE group_id = '".$group_id."' AND menu_id = '".$menu_id."';
                        INSERT INTO groups_access
                                       (group_id
                                       ,menu_id
                                       ,privilege)
                             VALUES
                                       ('".$group_id."'
                                       ,'".$menu_id."'
                                       ,'".$privilege."');";
            }    
            $resl = $this->db->simple_query($str);
            if( ! $resl){
                $err = $this->db->error();
                $this->title = "Kesalahan";
                $this->res = "<i class=\"fa fa-fw fa-warning\"></i> Error : ". $this->apps->err_code($err['message']);
                $this->state = "0";
            }else{
                $this->title = "Berhasil";
                $this->res = "<label class=\"label label-success\">Data Updated</label>";
                $this->state = "1";
            }
            
        }catch (Exception $e) {    
            $this->title = "Kesalahan";        
            $this->res = $e->getMessage();
            $this->state = "0";
        } 
        
        $arr = array(
            'title' => $this->title,
            'state' => $this->state, 
            'msg' => $this->res,
            'csrf_return' => $this->security->get_csrf_hash(),
            );
        return json_encode($arr);
    }
}
