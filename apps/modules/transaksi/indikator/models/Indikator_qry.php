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
 * Description of Indikator_qry
 *
 * @author adi
 */
class Indikator_qry extends CI_Model {

    //put your code here
    protected $res = "";
    protected $delete = "";
    protected $state = "";

    public function __construct() {
        parent::__construct();
    }

    public function select_data($param) {
        $this->db->where('id', $param);
        $query = $this->db->get('m_indikator');
        return $query->result_array();
    }

    public function get_m_unit() {
        $query = $this->db->get('m_unit');
        return $query->result_array();
    }

    public function get_m_jenis() {
        $query = $this->db->get('m_jenis');
        return $query->result_array();
    }

    public function get_m_tipe() {
        $query = $this->db->get('m_tipe');
        return $query->result_array();
    }

    public function get_data_indikator($id) {
        $str = "SELECT 
                    m_indikator.id,
                    m_unit.nama AS nm_unit,
                    m_jenis.nama AS nm_jenis,
                    m_tipe.nama AS nm_tipe,
                    m_indikator.urut,
                    m_indikator.nama,
                    m_indikator.standar,
                    m_indikator.dimensi,
                    m_indikator.tujuan,
                    m_indikator.definisi,
                    m_indikator.inklusi,
                    m_indikator.eksklusi,
                    m_indikator.frekuensi,
                    m_indikator.periode_analisa,
                    m_indikator.num,
                    m_indikator.denum,
                    m_indikator.sumber_data,
                    m_indikator.nama_pj
                    FROM m_indikator
                LEFT JOIN m_jenis ON m_jenis.id = m_indikator.jenis_id
                LEFT JOIN m_unit ON m_unit.id = m_indikator.unit_id
                LEFT JOIN m_tipe ON m_tipe.id = m_indikator.tipe_id
                    WHERE m_indikator.id = '{$id}'";
        $query = $this->db->query($str);
        if($query->num_rows()>0){
            return $query->row();
        }else{
            return false;
        }
    }

    public function submit() {
        try {
            $array = $this->input->post();
            if (empty($array['id'])) {
                unset($array['id']);
                $array['urut'] = $this->get_urut($array['unit_id'], $array['jenis_id']);
                $resl = $this->db->insert('m_indikator', $array);
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
                $resl = $this->db->update('m_indikator', $array);
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
            } elseif (!empty($array['id']) && ($array['stat'] == "delete")) {
                $this->db->where('id', $array['id']);
                $resl = $this->db->delete('m_indikator');
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
            } elseif (!empty($array['id']) && ($array['stat'] == "deleteall")) {
                $this->db->trans_begin();
                foreach ($array['id'] as $value) {
                    $this->db->where('id', $value);
                    $resl = $this->db->delete('m_indikator');
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

    public function submit_trn_indikator() {
        try {
            $array = $this->input->post();
            if (!empty($array['indikator_id'])) {
                $is_exist = $this->db->get_where('trn_indikator', array(
                    'indikator_id' => $array['indikator_id'],
                    'tgl_tran' => date('Y-m-d'),
                ))->num_rows();
                if($is_exist){
                    $array['user_id'] = $this->session->userdata('userid');
                    $array['tgl_edit'] = date('Y-m-d H:i:s');
                    $this->db->where('indikator_id', $array['indikator_id']);
                    $this->db->where('tgl_tran', date('Y-m-d'));
                    $resl = $this->db->update('trn_indikator', $array);
                }else{
                    $array['user_id'] = $this->session->userdata('userid');
                    $array['tgl_add'] = date('Y-m-d H:i:s');
                    $array['tgl_tran'] = date('Y-m-d');
                    $resl = $this->db->insert('trn_indikator', $array);
                }
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
            } 
            else {
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
    
    private function get_urut($unit_id, $jenis_id){
        $count = $this->db->get_where("m_indikator", array(
            'unit_id' => $unit_id,
            'jenis_id' => $jenis_id,
        ))->num_rows();
        for($i=1;$i<=((int) $count+1);$i++){
            $is_exist = $this->db->get_where("m_indikator", array(
                    'unit_id' => $unit_id,
                    'jenis_id' => $jenis_id,
                    'urut' => $i,
                ))->num_rows();
            if(!$is_exist){
                return $i;
            }
        }
    }
}
