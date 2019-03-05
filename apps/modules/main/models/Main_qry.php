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
 * Description of Main_qry
 *
 * @author adi
 */
class Main_qry extends CI_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function get_m_unit() {
        $unit_id = $this->uri->segment(3);
        $res = $this->db->get_where('m_unit', array('id' => $unit_id,'stat' => 'Aktif'))->row();
        if($res){
            return (array) $res;
        }else{
            return false;
        }
    }
    
    public function get_widget_top() {
        $periode = $this->input->get('periode');
        if(!$periode){
            $periode = date("m-Y");
        }
        $mY = explode("-", $periode);
        $month = $mY[0];
        $year = $mY[1];
        $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $jml_unit = $this->db->get_where("m_unit", array('stat' => 'Aktif'))->num_rows();
        $jml_indikator = $this->db->get_where("m_indikator", array('stat' => 'Aktif'))->num_rows();
        //SUM(ROUND((trn_indikator.num / trn_indikator.denum) * 100)) / ".intval($days)." AS hasil
        $str_all_unit = "SELECT 
                                CAST((SUM(hasil_all) / COUNT(unit_id)) AS DECIMAL (18 , 2 )) AS hasil_avg
                            FROM
                                (SELECT 
                                    unit_id, SUM(hasil) / COUNT(indikator_id) AS hasil_all
                                FROM
                                    (SELECT 
                                    m_indikator.id AS indikator_id,
                                        m_unit.id AS unit_id,
                                        AVG(ROUND((trn_indikator.num / trn_indikator.denum) * 100)) AS hasil
                                FROM
                                    m_unit
                                LEFT JOIN m_indikator ON m_unit.id = m_indikator.unit_id
                                LEFT JOIN (SELECT * FROM trn_indikator WHERE date_format(tgl_tran,'%m-%Y') = '{$periode}') trn_indikator ON m_indikator.id = trn_indikator.indikator_id
                                WHERE m_indikator.stat = 'Aktif'
                                GROUP BY m_indikator.id , m_unit.id) AS avg_unit
                                GROUP BY unit_id
                        ) avg_all";
        $row_all_unit = $this->db->query($str_all_unit)->row();
        if ($row_all_unit) {
            $avg_all_unit = (float) $row_all_unit->hasil_avg;
        } else {
            $avg_all_unit = 0;
        }
        $periode_nilai = month_id($year."-".$month);

        $res = array(
            'jml_unit' => $jml_unit,
            'jml_indikator' => $jml_indikator,
            'avg_all_unit' => $avg_all_unit,
            'periode_nilai' => $periode_nilai,
        );

        return $res;
    }

    public function get_unit_mutu_avg() {
        $order = $this->input->get('order');
        $periode = $this->input->get('periode');
        $days = 0;
        if($periode){
            $mY = explode("-", $periode);
            $month = $mY[0];
            $year = $mY[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        if (!$order) {
            $order = "DESC";
        }
        // SUM(ROUND((trn_indikator.num / trn_indikator.denum) * 100)) / ".intval($days)." AS hasil
        $str = "SELECT 
                    m_unit.id,
                    m_unit.nama,
                    m_unit.keterangan, 
                    ROUND(SUM(hasil) / COUNT(indikator_id)) AS hasil_all
                FROM m_unit 
                LEFT JOIN 
                    (SELECT 
                        m_indikator.id AS indikator_id,
                            m_unit.id AS unit_id,
                            AVG(ROUND((trn_indikator.num / trn_indikator.denum) * 100)) AS hasil
                    FROM
                        m_unit
                    LEFT JOIN m_indikator ON m_unit.id = m_indikator.unit_id
                    LEFT JOIN (SELECT * FROM trn_indikator WHERE date_format(tgl_tran,'%m-%Y') = '{$periode}') trn_indikator ON m_indikator.id = trn_indikator.indikator_id
                    WHERE m_indikator.stat = 'Aktif'
                    GROUP BY m_indikator.id , m_unit.id) AS avg_unit
                ON m_unit.id = avg_unit.unit_id
                WHERE m_unit.stat = 'Aktif'
                GROUP BY m_unit.id, m_unit.nama
                ORDER BY ROUND(SUM(hasil) / COUNT(indikator_id)) {$order}
                LIMIT 10";
        $qry = $this->db->query($str);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return false;
        }
    }

    public function get_mutu_per_unit() {
        $unit_id = $this->input->get('unit_id');
        $periode = $this->input->get('periode');
        $days = 0;
        if($periode){
            $mY = explode("-", $periode);
            $month = $mY[0];
            $year = $mY[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        
        $tgl_tran = date('Y-m');
        $header = array(
            'No.',
            'ID Indikator',
            'Indikator',
            'Jenis',
            'Standar',
        );
        $columns = "";
        $total = "";
        for ($i = 1; $i <= $days; $i++) {
            $num_day = str_pad($i, 2, "0", STR_PAD_LEFT);
            $columns .= " , SUM(ROUND(CASE WHEN date_format(trn_indikator.tgl_tran,'%d') = '{$num_day}' THEN (trn_indikator.num / trn_indikator.denum) * 100 ELSE 0 END)) AS h_" . $num_day;
            $total .= " AVG(ROUND(CASE WHEN date_format(trn_indikator.tgl_tran,'%d') = '{$num_day}' THEN (trn_indikator.num / trn_indikator.denum) * 100 ELSE 0 END)) +";
            $cell = array('data' => $num_day, 'style' => 'width: 10px');
            array_push($header, $cell);
        }
        if($total){
            $total = substr($total, 0, strlen($total) - 1);
            //$total = " , ROUND((" . $total . ") / " . $days . ") AS total";
            $total = " , ROUND((" . $total . ")) AS total";
            array_push($header, "Avg");
        }
        if (!$columns) {
            return false;
        }
        
        $str = "SELECT @rank:=@rank+1 AS nourut, nilai_indikator.* FROM ( SELECT 
                    m_indikator.id AS id_indikator,
                    m_indikator.nama AS nama_indikator,
                    m_jenis.nama AS nama_jenis,
                    m_indikator.standar
                    {$columns}
                    {$total}
                FROM m_unit
                LEFT JOIN m_indikator ON m_unit.id = m_indikator.unit_id
                LEFT JOIN m_jenis ON m_jenis.id = m_indikator.jenis_id
                LEFT JOIN ( SELECT * FROM trn_indikator WHERE date_format(tgl_tran,'%m-%Y') = '{$periode}' )trn_indikator ON m_indikator.id = trn_indikator.indikator_id
                WHERE m_unit.id = '{$unit_id}'
                    AND m_indikator.stat = 'Aktif'
                GROUP BY m_indikator.id,
                    m_indikator.nama,
                    m_jenis.nama,
                    m_indikator.standar ) nilai_indikator
                CROSS JOIN (SELECT @rank:=0) AS nos";
        $qry = $this->db->query($str);
        if ($qry->num_rows() > 0) {
            $this->load->library('table');
            $template = array(
                'table_open' => '<table class="table table-sm table-hover table-bordered table-nilai-indikator">',
                'thead_open' => '<thead>',
                'thead_close' => '</thead>',
                'heading_row_start' => '<tr>',
                'heading_row_end' => '</tr>',
                'heading_cell_start' => '<th>',
                'heading_cell_end' => '</th>',
                'tbody_open' => '<tbody>',
                'tbody_close' => '</tbody>',
                'row_start' => '<tr>',
                'row_end' => '</tr>',
                'cell_start' => '<td>',
                'cell_end' => '</td>',
                'row_alt_start' => '<tr>',
                'row_alt_end' => '</tr>',
                'cell_alt_start' => '<td>',
                'cell_alt_end' => '</td>',
                'table_close' => '</table>'
            );
            $this->table->set_heading($header);
            $this->table->set_template($template);
            echo $this->table->generate($qry);                
        } else {
            return false;
        }
    }

    public function get_mutu_indikator() {
        $unit_id = $this->input->get('unit_id');
        $periode = $this->input->get('periode');
        $days = 0;
        if($periode){
            $mY = explode("-", $periode);
            $month = $mY[0];
            $year = $mY[1];
            $days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        }
        
        $columns = "";
        $indikator = $this->db->get_where("m_indikator", array(
            "unit_id" => $unit_id,
            "stat" => 'Aktif',
                ))->result_array();
        $data_indikator = array();
        if($indikator){
            foreach ($indikator as $value) {
                $columns .= " , SUM(ROUND(CASE WHEN m_indikator.id = '".$value['id']."' THEN (trn_indikator.num / trn_indikator.denum) * 100 ELSE 0 END)) AS i_" . $value['id'];
                $data_indikator["i_".$value['id']] = $value['nama'];
            }
        }else{
            return false;
        }
        
        if (!$columns) {
            return false;
        }
        
        $str = "SELECT date_format(trn_indikator.tgl_tran,'%d') AS tgl_tran
                    {$columns}
                FROM m_unit
                LEFT JOIN m_indikator ON m_unit.id = m_indikator.unit_id
                LEFT JOIN m_jenis ON m_jenis.id = m_indikator.jenis_id
                LEFT JOIN ( SELECT * FROM trn_indikator WHERE date_format(tgl_tran,'%m-%Y') = '{$periode}')trn_indikator ON m_indikator.id = trn_indikator.indikator_id
                WHERE m_unit.id = '{$unit_id}' AND m_indikator.stat = 'Aktif' 
                    AND trn_indikator.tgl_tran IS NOT NULL
                GROUP BY trn_indikator.tgl_tran";
        $qry = $this->db->query($str);
        if ($qry->num_rows() > 0) {
            $res = array(
                'data' => $qry->result_array(),
                'data_indkator' => $data_indikator,
                'jml_hari' => $days,
            );
        }else{
            $res = array(
                'data' => null,
                'data_indkator' => $data_indikator,
                'jml_hari' => $days,
            );
        }
        return $res;
    }
}
