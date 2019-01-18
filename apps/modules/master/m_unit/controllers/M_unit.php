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
 * Description of M_unit
 *
 * @author adi
 */
class M_unit extends MY_Controller {

    protected $data = '';
    protected $val = '';

    public function __construct() {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            'submit' => site_url('m_unit/submit'),
            'show_form' => site_url('m_unit/form'),
            'reload' => site_url('m_unit'),
        );
        $this->load->model('m_unit_qry');
    }

    public function index() {
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
        $columns = array('id', 'id', 'nama', 'keterangan', 'id',);
        $table = ' m_unit ';
        $index = "id";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }

    public function submit() {
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');

        if ($this->validate($id, $stat) == TRUE) {
            $res = $this->m_unit_qry->submit();
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

    private function _init_add() {

        $this->data['form'] = array(
            'id' => array(
                'type' => 'hidden',
                'placeholder' => 'ID',
                'id' => 'id',
                'name' => 'id',
                'value' => set_value('id'),
                'class' => 'form-control ',
            ),
            'nama' => array(
                'placeholder' => 'Nama Unit Pelayanan',
                'id' => 'nama',
                'name' => 'nama',
                'value' => set_value('nama'),
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'keterangan' => array(
                'placeholder' => 'Keterangan',
                'id' => 'keterangan',
                'name' => 'keterangan',
                'value' => set_value('keterangan'),
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 80px;min-height: 80px;',
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
            'nama' => array(
                'placeholder' => 'Nama Unit Pelayanan',
                'id' => 'nama',
                'name' => 'nama',
                'value' => $this->val[0]['nama'],
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'keterangan' => array(
                'placeholder' => 'Keterangan',
                'id' => 'keterangan',
                'name' => 'keterangan',
                'value' => $this->val[0]['keterangan'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 80px;min-height: 80px;',
            ),
        );
    }

    private function _check_id($id) {
        if (empty($id)) {
            return false;
        }

        $this->val = $this->m_unit_qry->select_data($id);

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
                'field' => 'nama',
                'label' => 'Nama Unit Pelayanan',
                'rules' => 'required|max_length[100]',
            ),
            array(
                'field' => 'keterangan',
                'label' => 'Keterangan',
                'rules' => 'max_length[255]',
            ),
        );

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }
}
