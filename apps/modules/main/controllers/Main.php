<?php defined('BASEPATH') OR exit('No direct script access allowed');
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
 * Description of Main
 *
 * @author adi
 */
class Main extends MY_Controller {
    protected $data = array();
    public function __construct()
    {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
        );
        $this->load->model('main_qry');
    }

    //redirect if needed, otherwise display the user list
    
    public function index(){  
        $this->data['wiget_top'] = $this->main_qry->get_widget_top();
        $this->data['unit_mutu_avg'] = $this->main_qry->get_unit_mutu_avg();
        $this->template
            ->title("Dashboard", $this->apps->name)
            ->set_layout('main-layout')
            ->build('index',$this->data);
    }   
    
    public function mutu_unit(){  
        $this->data['unit'] = $this->main_qry->get_m_unit();
        $this->template
            ->title("Dashboard", $this->apps->name)
            ->set_layout('main-layout')
            ->build('mutu_unit',$this->data);
    }
    
    public function get_widget_top() {
        $res = $this->main_qry->get_widget_top();
        echo json_encode($res);
    }
    
    public function get_unit_mutu_avg() {
        $res = $this->main_qry->get_unit_mutu_avg();
        echo json_encode($res);
    }
    
    public function get_mutu_indikator() {
        $res = $this->main_qry->get_mutu_indikator();
        echo json_encode($res);
    }
    
    public function json_dgview_avg_unit() {
        $columns = array('nourut', 'nama', 'hasil_all', 'hasil_all', 'id');
        $table = " (SELECT 
                        @rank:=@rank+1 AS nourut,
                        m_unit.id,
                        m_unit.nama,
                        m_unit.keterangan, 
                        ROUND(SUM(hasil) / COUNT(indikator_id)) AS hasil_all
                    FROM m_unit 
                        CROSS JOIN (SELECT @rank:=0) AS nos
                    LEFT JOIN 
                        (SELECT 
                            m_indikator.id AS indikator_id,
                                m_unit.id AS unit_id,
                                SUM(ROUND((trn_indikator.num / trn_indikator.denum) * 100)) / 31 AS hasil
                        FROM
                            m_unit
                        LEFT JOIN m_indikator ON m_unit.id = m_indikator.unit_id
                        LEFT JOIN trn_indikator ON m_indikator.id = trn_indikator.indikator_id
                        GROUP BY m_indikator.id, m_unit.id) AS avg_unit
                    ON m_unit.id = avg_unit.unit_id
                    WHERE m_unit.stat = 'Aktif'
                    GROUP BY m_unit.id, m_unit.nama) AS avg_unit ";
        $index = "id";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }
    
    private function _init_add(){
        $this->data['form'] = array(
           'periode_awal'=> array(
                    'placeholder' => 'Periode Awal',
                    'id'          => 'periode_awal',
                    'name'        => 'periode_awal',
                    'class'       => 'form-control month',
                    'required'    => '',
                    'value'       => date('d-m-Y'),
            ),
           'periode_akhir'=> array(
                    'placeholder' => 'Periode',
                    'id'          => 'periode_akhir',
                    'name'        => 'periode_akhir',
                    'class'       => 'form-control calendar',
                    'required'    => '',
                    'value'       => date('d-m-Y'),
            ),    
        );
    }  
    
    public function get_mutu_per_unit() {
        $res = $this->main_qry->get_mutu_per_unit();
        echo $res;
    }
}
