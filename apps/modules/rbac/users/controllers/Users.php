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
 * Description of Users
 *
 * @author adi
 */
class Users extends MY_Controller {

    protected $data = '';
    protected $val = '';
    protected $opt_group_id = array();
    protected $opt_unit_id = array();
    protected $opt_tokoid = array();

    public function __construct() {
        parent::__construct();
        $this->data = array(
            'msg_main' => $this->msg_main,
            'msg_detail' => $this->msg_detail,
            'submit' => site_url('users/submit'),
            'show_form' => site_url('users/form'),
            'reload' => site_url('users'),
        );
        $this->load->model('users_qry');

        $group_id = $this->users_qry->ref_mstgroup();
        $this->opt_group_id[''] = '-- Pilih Group --';
        foreach ($group_id as $value) {
            $this->opt_group_id[$value['id']] = $value['name'];
        }
        
        
        $unit_id = $this->users_qry->ref_mstunit();
        $this->opt_unit_id[''] = '-- Pilih Unit Pelayanan --';
        foreach ($unit_id as $value) {
            $this->opt_unit_id[$value['id']] = $value['nama'];
        }
    }

    public function index() {
        $this->template
            ->title($this->msg_main, $this->apps->name)
            ->set_layout('main-layout')
            ->build('index',$this->data);
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
        $columns = array('id', 'unitname','full_name', 'email', 'groupname', 'active');
        $table = "(SELECT
                        users.id,
                        users.email,
                        users.last_login,
                        CASE WHEN users.active = 1 THEN 'Aktif' ELSE 'Tidak' END AS active,
                        users.full_name,
                        groups.name AS groupname,
                        m_unit.nama as unitname
                    FROM users
                        LEFT JOIN m_unit
                            ON m_unit.id = users.unit_id
                        LEFT JOIN users_groups
                            ON users_groups.user_id = users.id
                        LEFT JOIN groups 
                            ON users_groups.group_id = groups.id) AS a ";
        $index = "id";
        $output = $this->paw_table->output($columns, $table, $index);
        echo $output;
    }

    public function ref_mstlokasi() {
        echo $this->users_qry->ref_mstlokasi();
    }  
    
    public function submit() {
        $id = $this->input->post('id');
        $stat = $this->input->post('stat');

        if ($this->validate($id, $stat) == TRUE) {
            $res = $this->users_qry->submit();
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
            'full_name' => array(
                'placeholder' => 'Nama Lengkap',
                'id' => 'full_name',
                'name' => 'full_name',
                'value' => set_value('full_name'),
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'username' => array(
                'placeholder' => 'Nama Pengguna',
                'id' => 'username',
                'name' => 'username',
                'value' => set_value('username'),
                'class' => 'form-control ',
                'required' => '',
            ),
            'email' => array(
                'placeholder' => 'Email',
                'id' => 'email',
                'name' => 'email',
                'value' => set_value('email'),
                'class' => 'form-control ',
                'required' => '',
            ),
            'password' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'password',
                'name' => 'password',
                'value' => set_value('password'),
                'class' => 'form-control ',
            ),
            'password_confirm' => array(
                'type' => 'password',
                'placeholder' => 'Ulangi Password',
                'id' => 'password_confirm',
                'name' => 'password_confirm',
                'value' => set_value('password_confirm'),
                'class' => 'form-control ',
            ),
            'unit_id'=> array(
                'attr'        => array(
                    'id'    => 'unit_id',
                    'class' => 'form-control ',
                ),
                'data'     => $this->opt_unit_id,
                'value'   => set_value('unit_id'),
                'name'     => 'unit_id',
            ),
            'group_id'=> array(
                    'attr'        => array(
                        'id'    => 'group_id',
                        'class' => 'form-control ',
                    ),
                    'data'     => $this->opt_group_id,
                    'value'   => set_value('group_id'),
                    'name'     => 'group_id',
            ),
            'active'=> array(
                    'attr'        => array(
                        'id'    => 'active',
                        'class' => 'form-control ',
                    ),
                    'data'     => array('1'=>'Aktif','0'=>'Tidak',),
                    'value'   => set_value('active'),
                    'name'     => 'active',
            ),
        );
    }

    private function _init_edit($id = null) {
        if (!$id) {
            $id = $this->uri->segment(3);
        }
        $this->_check_id($id);
        $this->data['val'] = $this->val;
        $this->data['form'] = array(
            'id' => array(
                'type' => 'hidden',
                'placeholder' => 'ID',
                'id' => 'id',
                'name' => 'id',
                'value' => $this->val[0]['id'],
                'class' => 'form-control ',
            ),
            'full_name' => array(
                'placeholder' => 'Nama Lengkap',
                'id' => 'full_name',
                'name' => 'full_name',
                'value' => $this->val[0]['full_name'],
                'class' => 'form-control ',
                'required' => '',
                'autofocus' => ''
            ),
            'username' => array(
                'placeholder' => 'Nama Pengguna',
                'id' => 'username',
                'name' => 'username',
                'value' => $this->val[0]['username'],
                'class' => 'form-control ',
                'required' => '',
            ),
            'email' => array(
                'placeholder' => 'Email',
                'id' => 'email',
                'name' => 'email',
                'value' => $this->val[0]['email'],
                'class' => 'form-control ',
                'required' => '',
            ),
            'password' => array(
                'type' => 'password',
                'placeholder' => 'Password',
                'id' => 'password',
                'name' => 'password',
                'value' => '',
                'class' => 'form-control ',
            ),
            'password_confirm' => array(
                'type' => 'password',
                'placeholder' => 'Ulangi Password',
                'id' => 'password_confirm',
                'name' => 'password_confirm',
                'value' => '',
                'class' => 'form-control ',
            ),
            'group_id'=> array(
                    'attr'        => array(
                        'id'    => 'group_id',
                        'class' => 'form-control ',
                    ),
                    'data'     => $this->opt_group_id,
                    'value'   => $this->val[0]['group_id'],
                    'name'     => 'group_id',
            ),
            'unit_id'=> array(
                'attr'        => array(
                    'id'    => 'unit_id',
                    'class' => 'form-control ',
                ),
                'data'     => $this->opt_unit_id,
                'value'   => $this->val[0]['unit_id'],
                'name'     => 'unit_id',
            ),
            'active'=> array(
                    'attr'        => array(
                        'id'    => 'active',
                        'class' => 'form-control ',
                    ),
                    'data'     => array('1'=>'Aktif','0'=>'Tidak',),
                    'value'   => $this->val[0]['active'], // disini set nya
                    'name'     => 'active',
            ),
        );
    }

    private function _check_id($id) {
        if (empty($id)) {
            return false;
        }

        $this->val = $this->users_qry->select_data($id);

        if (empty($this->val)) {
            return false;
        }
    }

    private function validate($id, $stat) {
        
        if(!empty($id) && !empty($stat)){
            return true;
        }
        $config = array(
            array(
                    'field' => 'full_name',
                    'label' => 'Nama Lengkap',
                    'rules' => 'required|max_length[50]',
                ),
            array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'trim|required|max_length[100]',
                    ),
        );
        if(!empty($id)){
            $username = array(
                        'field' => 'username',
                        'label' => 'Nama Pengguna',
                        'rules' => 'trim|required|max_length[100]',
                    );
            array_merge($config,$username);
            
            $pass = array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|max_length[8]',
                    );
            array_merge($config,$pass);
            
            $pass_confirm = array(
                    'field' => 'password_confirm',
                    'label' => 'Password Confirm',
                    'rules' => 'trim|matches[password]|max_length[8]',
                    );
            array_merge($config,$pass_confirm);
        }else{
            $username = array(
                        'field' => 'username',
                        'label' => 'Nama Pengguna',
                        'rules' => 'trim|required|max_length[100]|is_unique[users.username]',
                    );            
            array_merge($config,$username);
            
            $pass = array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'trim|required|max_length[8]',
                    );
            array_merge($config,$pass);
            
            $pass_confirm = array(
                    'field' => 'password_confirm',
                    'label' => 'Password Confirm',
                    'rules' => 'trim|required|matches[password]|max_length[8]',
                    );
            array_merge($config,$pass_confirm);
        }
        $this->form_validation->set_rules($config);   
        if ($this->form_validation->run() == FALSE)
        {
            return false;
        }else{
            return true;
        }
    }
    
}
