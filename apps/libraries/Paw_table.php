<?php

/*
 * ***************************************************************
 * Script : Paw_table.php 
 * Version : 1.0.0
 * Date : Mar 1, 2018 / 10:38:17 AM
 * Author : Pudyasto
 * Email : mr.pudyasto@gmail.com
 * Description : Simple datatable json generator library for codeiginter 3.X
 * ***************************************************************
 */

/**
 * Description of Paw_table
 *
 * @author Pudyasto
 */
class Paw_table {

    //put your code here
    protected $aColumns;
    protected $sIndexColumn;
    protected $sLimit;
    protected $sTable;
    protected $sOrder;
    protected $sWhere;
    protected $sQuery;
    protected $rResult;
    protected $iTotalDisplayRecords;
    protected $iTotalRecords;
    protected $iDetail;
    protected $database;
    
    public function __construct() {
        $this->ci = & get_instance();
        $this->database = 'default';
    }
    
    public function output($column,  $table, $index = null, $subtable = null, $table_key = null, $database=null) {
        if($database){
            $this->database = $database;
        }
        $get = $this->ci->input->post();
        if(empty($get)){
            $get = $this->ci->input->get();
        }
        $this->aColumns = $column;
        $this->sTable = $table;
        if($index){
            $this->sIndexColumn = $index;
        }else{
            $this->sIndexColumn = $this->aColumns[0];
        }
        $this->_set_limit($get);
        $this->_set_order($get);
        $this->_set_where($get);
        $this->_set_total_records();
        $this->_set_query();
        
        if(!isset($get['sEcho'])){
            return "Kesalahan, ID Key tidak ada!";
        }
        if(intval($get['sEcho'])>0){
            $output = array(
                "sEcho" => intval($get['sEcho']),
                "iTotalRecords" => $this->iTotalRecords,
                "iTotalDisplayRecords" => $this->iTotalDisplayRecords,
                "aaData" => array(),
//                "qry" => $this->ci->db->last_query(),
            );
            if($subtable!==null && $table_key!==null){
                $this->iDetail = $this->_sub_table($subtable);
            }
            foreach ($this->rResult->result_array() as $aRow) {
                $row = array();
                foreach ($aRow as $key => $val) {
                    if(is_numeric($val)){
                        $row[$key] = $val; //(float) $val;
                    }else{
                        $row[$key] = $val;
                    }
                }
                if($this->iDetail){
                    $row['detail'] = array();
                    foreach ($this->iDetail as $v_detail) {
                        if ($row[$table_key] == $v_detail[$table_key]) {
                            $row['detail'][] = $v_detail;
                        }
                    } 
                }               
                $output['aaData'][] = $row;
            }
        }else{
            $output = array(
                "sEcho" => intval($get['sEcho']),
                "iTotalRecords" => 0,
                "iTotalDisplayRecords" => 0,
                "aaData" => array(),
            );
        }
        $csrf_hash = $this->ci->security->get_csrf_hash(); 
        $output['csrf_return'] = $csrf_hash;   
        return json_encode($output);
    }

    private function _set_limit($get) {
        if (!empty($get['iDisplayLength']) && $get['iDisplayLength'] != '-1') {
            $this->sLimit = " LIMIT " . $get['iDisplayLength'];
        } 
        
        if (isset( $get['iDisplayStart'] ) && $get['iDisplayLength'] != '-1') {
            if (intval($get['iDisplayStart']) > 0) {
                $this->sLimit = " LIMIT ".intval( $get['iDisplayLength'] )." OFFSET ".
                        intval( $get['iDisplayStart'] );
            }
        }
    }

    private function _set_order($get) {
        if (isset( $get['iSortCol_0'])) {
            $this->sOrder = " ORDER BY  ";
            for ($i = 0; $i < intval($get['iSortingCols']); $i++) {
                if ($get['bSortable_' . intval($get['iSortCol_' . $i])] == "true") {
                    $this->sOrder .= "" . $this->aColumns[intval($get['iSortCol_' . $i])] . " " .
                            ($get['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $this->sOrder = substr_replace($this->sOrder, "", -2);
            if ($this->sOrder == " ORDER BY") {
                $this->sOrder = "";
            }
        }
    }

    private function _set_where($get) {
        if (isset($get['sSearch']) && $get['sSearch'] != "") {
            $this->sWhere = " Where (";
            for ($i = 0; $i < count($this->aColumns); $i++) {
                $this->sWhere .= "lower(" . $this->aColumns[$i] . ") LIKE '%"
                        . strtolower($this->ci->db->escape_str($get['sSearch'])) . "%' OR ";
            }
            $this->sWhere = substr_replace($this->sWhere, "", -3);
            $this->sWhere .= ')';
        }

        for ($i = 0; $i < count($this->aColumns); $i++) {
            if (isset($get['bSearchable_' . $i]) && $get['bSearchable_' . $i] == "true" && $get['sSearch_' . $i] != '') {
                if ($this->sWhere == "") {
                    $this->sWhere = " WHERE ";
                } else {
                    $this->sWhere .= " AND ";
                }
                $this->sWhere .= "lower(" . $this->aColumns[$i] . ")  LIKE '%"
                        . strtolower($this->ci->db->escape_str($get['sSearch_' . $i])) . "%' ";
            }
        }
    }
    
    private function _set_total_records() {
        $q = "SELECT COUNT("
                . $this->sIndexColumn
                . ") res "
                . " FROM "
                . $this->sTable
                . $this->sWhere;

        $db = $this->ci->load->database($this->database, TRUE);
        $res = $db->query($q);
        $this->ci->load->database($this->database, FALSE);
        if($res->num_rows()>0){
            $data = $res->row();
            $this->iTotalDisplayRecords = $data->res;
        }
    }

    private function _set_query() {
        $this->sQuery = "SELECT "
                . str_replace(" , ", " ", implode(", ", $this->aColumns))
                . " FROM "
                . $this->sTable
                . $this->sWhere
                . $this->sOrder
                . $this->sLimit;
        $db = $this->ci->load->database($this->database, TRUE);
        $this->rResult = $db->query($this->sQuery);
        $this->ci->load->database($this->database, FALSE);   
        $this->iTotalRecords = $this->rResult->num_rows();
    }

    private function _sub_table($query){
        $output = array();
        $db = $this->ci->load->database($this->database, TRUE);
        $q = $db->query($query);
        $this->ci->load->database($this->database, FALSE);   
        $res = $q->result_array();

        foreach ($res as $aRow) {
            foreach ($aRow as $key => $value) {
                if (is_numeric($value)) {
                    $aRow[$key] = (float) $value;
                } else {
                    $aRow[$key] = $value;
                }
            }
            $output[] = $aRow;
        }
        return $output;
    }
}
