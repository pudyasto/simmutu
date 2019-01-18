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
 * Description of Groups
 *
 * @author adi
 */
class Groups extends MY_Controller {

    protected $data = '';
    protected $val = '';

    public function __construct() {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            'submit' => site_url('groups/submit'),
            'show_form' => site_url('groups/form'),
            'reload' => site_url('groups'),
        );
        $this->load->model('groups_qry');
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
        $columns = array('id', 'id', 'name', 'description', 'id',);
        $table = ' (SELECT  id, name, description
                    FROM groups) AS a ';
        $index = "id";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }

    public function submit() {
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');

        if ($this->validate($id, $stat) == TRUE) {
            $res = $this->groups_qry->submit();
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
            'name' => array(
                'placeholder' => 'Nama Group',
                'id' => 'name',
                'name' => 'name',
                'value' => set_value('name'),
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'description' => array(
                'placeholder' => 'Keterangan',
                'id' => 'description',
                'name' => 'description',
                'value' => set_value('description'),
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
            'name' => array(
                'placeholder' => 'Nama Group',
                'id' => 'name',
                'name' => 'name',
                'value' => $this->val[0]['name'],
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'description' => array(
                'placeholder' => 'Keterangan',
                'id' => 'description',
                'name' => 'description',
                'value' => $this->val[0]['description'],
                'class' => 'form-control ',
                'style' => 'resize: vertical;height: 80px;min-height: 80px;',
            ),
        );
    }

    private function _check_id($id) {
        if (empty($id)) {
            return false;
        }

        $this->val = $this->groups_qry->select_data($id);

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
                'field' => 'name',
                'label' => 'Nama Group',
                'rules' => 'required|alpha_numeric_spaces|max_length[20]',
            ),
            array(
                'field' => 'description',
                'label' => 'Keterangan',
                'rules' => 'alpha_numeric_spaces|max_length[100]',
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
     * Set Group Access
     */

    public function set_group_access() {
        $this->data['group_id'] = $this->input->get('id');
        echo $this->load->view('form_group_access', $this->data, false);
    }

    public function json_group_access() {
        $group_id = $this->input->post('group_id');
        $columns = array('set_access', 'menu_name', 'submenu', 'description', 'id');
        $table = " (SELECT a.menu_name, b.menu_name as submenu, b.description, b.id
                        , (SELECT group_id FROM groups_access AS tg 
                    WHERE group_id = '" . $group_id . "'
                            AND (menu_id = b.id) 
                            ) AS set_access
                                FROM menus AS a INNER JOIN
                            menus AS b ON a.id = b.mainmenuid
                            WHERE a.statmenu = 1
                            UNION ALL
                    SELECT a.menu_name, '' as submenu, a.description, a.id
                                            , (SELECT group_id FROM groups_access AS tg 
                                        WHERE group_id = '" . $group_id . "'
                                                AND (menu_id = a.id) 
                                                ) AS set_access
                                                    FROM menus AS a   
                    WHERE a.link <> '#' AND a.mainmenuid IS NULL
                    AND a.statmenu = 1
                            ) tran_group ORDER BY menu_name, menu_name";
        $index = "menu_name";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }

    public function submit_group_access() {
        echo $this->groups_qry->submit_group_access();
    }

}
