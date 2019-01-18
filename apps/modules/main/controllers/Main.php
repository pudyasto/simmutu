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
        $this->template
            ->title("Dashboard", $this->apps->name)
            ->set_layout('main-layout')
            ->build('index',$this->data);
    }   
    
    private function _init_add(){
        $this->data['form'] = array(
           'periode_awal'=> array(
                    'placeholder' => 'Periode Awal',
                    'id'          => 'periode_awal',
                    'name'        => 'periode_awal',
                    'class'       => 'form-control calendar',
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
}
