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

        
        if($this->session->userdata('unitid')){
            $this->db->where('id', $this->session->userdata('unitid'));
        }
        
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

    public function get_chart_nilai_unit() {
        $indikator_id = $this->input->get('indikator_id');
        $periode = $this->input->get('periode');
        $mY = explode("-", $periode);
        $month = $mY[0];
        $year = $mY[1];
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $str = "SELECT date_format(trn_indikator.tgl_tran,'%d') AS hari,
                    trn_indikator.num,
                    trn_indikator.denum,
                    ROUND((trn_indikator.num / trn_indikator.denum), 2) AS hasil
                FROM trn_indikator
                WHERE date_format(trn_indikator.tgl_tran,'%m-%Y') = '{$periode}'
                AND trn_indikator.indikator_id = '{$indikator_id}'
                ORDER BY tgl_tran ASC";
        $qry = $this->db->query($str);
        if($qry->num_rows()>0){
            $data = $qry->result_array();
            $array = array();
            for($i=1;$i<=$days;$i++){
                $array[$i]['hari'] = str_pad($i, 2, "0", STR_PAD_LEFT);
                $array[$i]['num'] = 0; 
                $array[$i]['denum'] = 0; 
                $array[$i]['hasil'] = 0; 
                foreach ($data as $value) {
                    if($i==(int) $value['hari']){
                        $array[$i]['hari'] = str_pad($i, 2, "0", STR_PAD_LEFT);
                        $array[$i]['num'] = $value['num']; 
                        $array[$i]['denum'] = $value['denum']; 
                        $array[$i]['hasil'] = $value['hasil']; 
                    }
                }
            }
        }else{
            for($i=1;$i<=$days;$i++){
                $array[$i]['hari'] = str_pad($i, 2, "0", STR_PAD_LEFT);
                $array[$i]['num'] = 0; 
                $array[$i]['denum'] = 0; 
                $array[$i]['hasil'] = 0; 
            }
        }
        return $array;
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
            if(!isset($array['stat'])){
                $array['stat'] = 'Tidak';
            }
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
            } elseif (!empty($array['id']) && empty($array['state'])) {
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
            } elseif (!empty($array['id']) && ($array['state'] == "delete")) {
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
            } elseif (!empty($array['id']) && ($array['state'] == "deleteall")) {
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
            if (!empty($array['indikator_id']) && !isset($array['state'])) {
                $is_exist = $this->db->get_where('trn_indikator', array(
                    'indikator_id' => $array['indikator_id'],
                    'tgl_tran' => $this->apps->dateconvert($array['tgl_tran']),
                ))->num_rows();
                if($is_exist){
                    $this->db->set('num', $array['num']);
                    $this->db->set('denum', $array['denum']);
                    $this->db->set('keterangan', $array['keterangan']);
                    $this->db->set('user_id', $this->session->userdata('userid'));
                    $this->db->set('tgl_edit', date('Y-m-d H:i:s'));
                    $this->db->where('indikator_id', $array['indikator_id']);
                    $this->db->where('tgl_tran', $this->apps->dateconvert($array['tgl_tran']));
                    $resl = $this->db->update('trn_indikator');
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
                }else{
                    $array['user_id'] = $this->session->userdata('userid');
                    $array['tgl_add'] = date('Y-m-d H:i:s');
                    $array['tgl_tran'] = $this->apps->dateconvert($array['tgl_tran']);
                    $resl = $this->db->insert('trn_indikator', $array);
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
            }
            else if (!empty($array['indikator_id']) && isset($array['state']) && ($array['state']=="delete")) {
                    $this->db->where('indikator_id', $array['indikator_id']);
                    $this->db->where('tgl_tran', $this->apps->dateconvert($array['tgl_tran']));
                    $resl = $this->db->delete('trn_indikator');
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
