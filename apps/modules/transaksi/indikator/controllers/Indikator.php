<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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
 * Description of Indikator
 *
 * @author adi
 */
class Indikator extends MY_Controller {

    protected $data = array();
    protected $val = '';

    public function __construct() {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            'submit' => site_url('indikator/submit'),
            'show_form' => site_url('indikator/form'),
            'reload' => site_url('indikator'),
        );
        $this->load->model('indikator_qry');
        $data_m_unit = $this->indikator_qry->get_m_unit();
        $this->data['unit_id'][''] = '-- Pilih Unit --';
        foreach ($data_m_unit as $value) {
            $this->data['unit_id'][$value['id']] = $value['nama'];
        }
        
        $data_m_jenis = $this->indikator_qry->get_m_jenis();
        $this->data['jenis_id'][''] = '-- Pilih Jenis Unit --';
        foreach ($data_m_jenis as $value) {
            $this->data['jenis_id'][$value['id']] = $value['nama'];
        }
        
        $data_m_tipe = $this->indikator_qry->get_m_tipe();
        foreach ($data_m_tipe as $value) {
            $this->data['tipe_id'][$value['id']] = $value['nama'];
        }
        
        $this->data['frekuensi'] = array(
            'Harian' => 'Harian',
            'Mingguan' => 'Mingguan',
            'Bulanan' => 'Bulanan',
            'Tahunan' => 'Tahunan',
        );
    }

    public function index() {
        $unit_id = $this->uri->segment(3);
        $this->_init_add($unit_id);
        $this->template
                ->title($this->msg_main,  $this->apps->name)
                ->set_layout('main-layout')
                ->build('index', $this->data);
    }

    public function form() {
        $id = $this->input->get('id');
        if ($id) {
            $this->_init_edit($id);
        } else {
            $this->_init_add();
        }
        echo $this->load->view('form', $this->data, false);
    }

    public function json_dgview() {
        $unit_id = $this->input->post('unit_id');
        $columns = array('id', 'urut', 'nm_jenis', 'nama', 'standar', 'id',);
        $table = " (SELECT 
                    m_indikator.id,
                    m_jenis.nama AS nm_jenis,
                    m_indikator.urut,
                    m_indikator.nama,
                    m_indikator.standar
                    FROM m_indikator
                    JOIN m_jenis ON m_jenis.id = m_indikator.jenis_id
                    WHERE m_indikator.unit_id = '{$unit_id}'
                    ORDER BY m_jenis.nama DESC, m_indikator.urut) AS m_unit ";
        $index = "id";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }

    public function submit() {
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');

        if ($this->validate($id, $stat) == TRUE) {
            $res = $this->indikator_qry->submit();
            echo $res;
        } else {
            $res = array(
                'state' => "0",
                'msg' => strip_tags(validation_errors()),
                'csrf_return' => $this->security->get_csrf_hash(),
            );
            echo json_encode($res);
        }
    }

    private function _init_add($unit_id = null) {
        $this->data['form'] = array(
            'id' => array(
                'type' => 'hidden',
                'placeholder' => 'ID',
                'id' => 'id',
                'name' => 'id',
                'value' => set_value('id'),
                'class' => 'form-control ',
            ),
            'unit_id'=> array(
                    'attr'        => array(
                        'id'    => 'unit_id',
                        'class' => 'form-control show-tick',
                        'data-live-search' => 'true',
                    ),
                    'data'     => $this->data['unit_id'],
                    'value'   => $unit_id,
                    'name'     => 'unit_id',
            ),
            'jenis_id'=> array(
                    'attr'        => array(
                        'id'    => 'jenis_id',
                        'class' => 'form-control  show-tick',
                        'data-live-search' => 'true',
                    ),
                    'data'     => $this->data['jenis_id'],
                    'value'   => set_value('jenis_id'),
                    'name'     => 'jenis_id',
            ),
            'nama' => array(
                'placeholder' => 'Judul Indikator',
                'id' => 'nama',
                'name' => 'nama',
                'value' => set_value('nama'),
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'definisi' => array(
                'placeholder' => 'Definisi',
                'id' => 'definisi',
                'name' => 'definisi',
                'value' => set_value('definisi'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'inklusi' => array(
                'placeholder' => 'Inklusi',
                'id' => 'inklusi',
                'name' => 'inklusi',
                'value' => set_value('inklusi'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'eksklusi' => array(
                'placeholder' => 'Eksklusi',
                'id' => 'eksklusi',
                'name' => 'eksklusi',
                'value' => set_value('eksklusi'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'tujuan' => array(
                'placeholder' => 'Tujuan',
                'id' => 'tujuan',
                'name' => 'tujuan',
                'value' => set_value('tujuan'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'num' => array(
                'placeholder' => 'Numerator',
                'id' => 'num',
                'name' => 'num',
                'value' => set_value('num'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'denum' => array(
                'placeholder' => 'Denumerator',
                'id' => 'denum',
                'name' => 'denum',
                'value' => set_value('denum'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'sumber_data' => array(
                'placeholder' => 'Sumber Data',
                'id' => 'sumber_data',
                'name' => 'sumber_data',
                'value' => set_value('sumber_data'),
                'class' => 'form-control ',
                'required' => '',
            ),
            'nama_pj' => array(
                'placeholder' => 'Penanggung Jawab',
                'id' => 'nama_pj',
                'name' => 'nama_pj',
                'value' => set_value('nama_pj'),
                'class' => 'form-control ',
                'required' => '',
            ),
            'periode_analisa' => array(
                'placeholder' => 'Periode Analisa',
                'type' => 'number',
                'min' => "0",
                'id' => 'periode_analisa',
                'name' => 'periode_analisa',
                'value' => set_value('periode_analisa'),
                'class' => 'form-control ',
                'required' => '',
            ),
            'tipe_id'=> array(
                    'attr'        => array(
                        'id'    => 'tipe_id',
                        'class' => 'form-control',
                    ),
                    'data'     => $this->data['tipe_id'],
                    'value'   => set_value('tipe_id'),
                    'name'     => 'tipe_id',
            ),
            'frekuensi'=> array(
                    'attr'        => array(
                        'id'    => 'frekuensi',
                        'class' => 'form-control ',
                    ),
                    'data'     => $this->data['frekuensi'],
                    'value'   => set_value('frekuensi'),
                    'name'     => 'frekuensi',
            ),
            'standar' => array(
                'placeholder' => 'Standar',
                'id' => 'standar',
                'name' => 'standar',
                'value' => set_value('standar'),
                'class' => 'form-control ',
                'required' => '',
            ),
        );
    }

    private function _init_edit($id = null) {
        if (!$id) {
            $id = $this->uri->segment(3);
        }
        $this->_check_id($id);
        $this->data['form'] = array(
            'id' => array(
                'type' => 'hidden',
                'placeholder' => 'ID',
                'id' => 'id',
                'name' => 'id',
                'value' => $this->val[0]['id'],
                'class' => 'form-control ',
            ),
            'unit_id'=> array(
                    'attr'        => array(
                        'id'    => 'unit_id',
                        'class' => 'form-control show-tick',
                        'data-live-search' => 'true',
                    ),
                    'data'     => $this->data['unit_id'],
                    'value'   => $this->val[0]['unit_id'],
                    'name'     => 'unit_id',
            ),
            'jenis_id'=> array(
                    'attr'        => array(
                        'id'    => 'jenis_id',
                        'class' => 'form-control  show-tick',
                        'data-live-search' => 'true',
                    ),
                    'data'     => $this->data['jenis_id'],
                    'value'   => $this->val[0]['jenis_id'],
                    'name'     => 'jenis_id',
            ),
            'nama' => array(
                'placeholder' => 'Judul Indikator',
                'id' => 'nama',
                'name' => 'nama',
                'value' => $this->val[0]['nama'],
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'definisi' => array(
                'placeholder' => 'Definisi',
                'id' => 'definisi',
                'name' => 'definisi',
                'value' => $this->val[0]['definisi'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'inklusi' => array(
                'placeholder' => 'Inklusi',
                'id' => 'inklusi',
                'name' => 'inklusi',
                'value' => $this->val[0]['inklusi'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'eksklusi' => array(
                'placeholder' => 'Eksklusi',
                'id' => 'eksklusi',
                'name' => 'eksklusi',
                'value' => $this->val[0]['eksklusi'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'tujuan' => array(
                'placeholder' => 'Tujuan',
                'id' => 'tujuan',
                'name' => 'tujuan',
                'value' => $this->val[0]['tujuan'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'num' => array(
                'placeholder' => 'Numerator',
                'id' => 'num',
                'name' => 'num',
                'value' => $this->val[0]['num'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'denum' => array(
                'placeholder' => 'Denumerator',
                'id' => 'denum',
                'name' => 'denum',
                'value' => $this->val[0]['denum'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'sumber_data' => array(
                'placeholder' => 'Sumber Data',
                'id' => 'sumber_data',
                'name' => 'sumber_data',
                'value' => $this->val[0]['sumber_data'],
                'class' => 'form-control ',
                'required' => '',
            ),
            'nama_pj' => array(
                'placeholder' => 'Penanggung Jawab',
                'id' => 'nama_pj',
                'name' => 'nama_pj',
                'value' => $this->val[0]['nama_pj'],
                'class' => 'form-control ',
                'required' => '',
            ),
            'periode_analisa' => array(
                'placeholder' => 'Periode Analisa',
                'min' => "0",
                'type' => 'number',
                'id' => 'periode_analisa',
                'name' => 'periode_analisa',
                'value' => $this->val[0]['periode_analisa'],
                'class' => 'form-control ',
                'required' => '',
            ),
            'tipe_id'=> array(
                    'attr'        => array(
                        'id'    => 'tipe_id',
                        'class' => 'form-control',
                    ),
                    'data'     => $this->data['tipe_id'],
                    'value'   => $this->val[0]['tipe_id'],
                    'name'     => 'tipe_id',
            ),
            'frekuensi'=> array(
                    'attr'        => array(
                        'id'    => 'frekuensi',
                        'class' => 'form-control ',
                    ),
                    'data'     => $this->data['frekuensi'],
                    'value'   => $this->val[0]['frekuensi'],
                    'name'     => 'frekuensi',
            ),
            'standar' => array(
                'placeholder' => 'Standar',
                'id' => 'standar',
                'name' => 'standar',
                'value' => $this->val[0]['standar'],
                'class' => 'form-control ',
                'required' => '',
            ),
        );
    }

    private function _check_id($id) {
        if (empty($id)) {
            return false;
        }

        $this->val = $this->indikator_qry->select_data($id);

        if (empty($this->val)) {
            return false;
        }
    }

    private function validate($id, $stat) {
        if (!empty($id) && !empty($stat)) {
            return true;
        }
        $config = array(
            array(
                'field' => 'unit_id',
                'label' => 'ID Unit',
                'rules' => 'required|integer',
            ),
            array(
                'field' => 'jenis_id',
                'label' => 'Jenis Unit',
                'rules' => 'required|integer',
            ),
            array(
                'field' => 'tipe_id',
                'label' => 'Tipe Indikator',
                'rules' => 'required|integer',
            ),
            array(
                'field' => 'sumber_data',
                'label' => 'Sumber Data',
                'rules' => 'required',
            ),
            array(
                'field' => 'nama_pj',
                'label' => 'Penanggung Jawab',
                'rules' => 'required',
            ),
            array(
                'field' => 'standar',
                'label' => 'Standar',
                'rules' => 'required',
            ),
            array(
                'field' => 'nama',
                'label' => 'Judul Indikator',
                'rules' => 'required',
            ),
            array(
                'field' => 'sumber_data',
                'label' => 'Sumber Data',
                'rules' => 'required|integer',
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }
    
    /*
     * Transaksi Indikator Mutu
     */
    public function form_trn_indikator() {
        $indikator_id = $this->input->get('id');
        if(!$indikator_id){
            return false;
        }
        $this->_init_add_trn_indikator($indikator_id);
        $this->data['detail'] = $this->indikator_qry->get_data_indikator($indikator_id);
        if($this->data['detail']===false){
            return false;
        }
        echo $this->load->view('form_trn_indikator', $this->data, false);
    }

    public function submit_trn_indikator() {
        if ($this->validate_trn_indikator() == TRUE) {
            $res = $this->indikator_qry->submit_trn_indikator();
            echo $res;
        } else {
            $res = array(
                'state' => "0",
                'msg' => strip_tags(validation_errors()),
                'csrf_return' => $this->security->get_csrf_hash(),
            );
            echo json_encode($res);
        }
    }
    
    public function get_chart_nilai_unit() {
        $res = $this->indikator_qry->get_chart_nilai_unit();
        echo json_encode($res);
    }
    
    public function json_dgview_trn_indikator() {
        $indikator_id = $this->input->post('indikator_id');
        $columns = array('tgl_tran', 'keterangan', 'num', 'denum', 'hasil', 'tgl_last',);
        $table = " (SELECT indikator_id,
                            tgl_tran,
                            keterangan,
                            num,
                            denum,
                            ROUND((num / denum),2) AS hasil,
                            user_id,
                            tgl_add,
                            tgl_edit,
                            CASE WHEN tgl_edit IS NULL THEN tgl_add
                            ELSE tgl_edit END AS tgl_last
                         FROM trn_indikator
                         WHERE indikator_id = '{$indikator_id}') AS trn_indikator ";
        $index = "tgl_tran";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }

    private function validate_trn_indikator() {
        $config = array(
            array(
                'field' => 'indikator_id',
                'label' => 'ID Indikator',
                'rules' => 'required|integer',
            ),
            array(
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'required',
            ),
            array(
                'field' => 'num',
                'label' => 'Numerator',
                'rules' => 'required|integer',
            ),
            array(
                'field' => 'denum',
                'label' => 'Denumerator',
                'rules' => 'required|integer',
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }
    
    private function _init_add_trn_indikator($indikator_id) {
        $this->data['form'] = array(
            'indikator_id' => array(
                'type' => 'hidden',
                'placeholder' => 'ID',
                'id' => 'indikator_id',
                'name' => 'indikator_id',
                'value' => $indikator_id,
                'class' => 'form-control ',
            ),
            'keterangan' => array(
                'placeholder' => 'Keterangan',
                'id' => 'keterangan',
                'name' => 'keterangan',
                'value' => set_value('keterangan'),
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => '',
                'style' => 'resize: vertical;height: 50px;min-height: 50px;',
            ),
            'num' => array(
                'placeholder' => 'Numerator',
                'id' => 'num',
                'name' => 'num',
                'value' => set_value('num'),
                'class' => 'form-control ',
                'required' => '',
            ),
            'denum' => array(
                'placeholder' => 'Denumerator',
                'id' => 'denum',
                'name' => 'denum',
                'value' => set_value('denum'),
                'class' => 'form-control ',
                'required' => '',
            ),
        );
    }
}
