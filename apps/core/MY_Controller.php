<?php

/*
 * ***************************************************************
 * Script : 
 * Version : 
 * Date :
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */

/**
 * Description of MY_Controller
 *
 * @author pudyasto
 */
class MY_Controller extends CI_Controller{  
    var $menu_app="";
    var $msg_active="";
    var $msg_main="";
    var $msg_detail="";
    var $csrf="";
    
    public function __construct()
    {
        parent::__construct();  

        $logged_in = $this->session->userdata('logged_in');
        
        if(!$logged_in){
            redirect($this->apps->ssoapp . '/access?url=' . $this->apps->curPageURL(),'refresh');
            exit;
        }
        
        $show = $this->rbac->module_access('show');
        if(empty($show)){
            redirect('debug/err_505');
            exit;
        }
        
        $kelas = $this->uri->segment(1);
        if($kelas=="dashboard" || empty($kelas)){
            $this->msg_main = "Selamat Datang ". ucwords(strtolower($this->session->userdata('name')));
            $this->msg_detail = ' <i class="fa fa-map-marker text-success"></i> '.$this->apps->logintag;
        }else{
            foreach($this->rbac->ceksubmenu_app($kelas) as $val){
                $this->msg_main = $val->menu_name;
                $this->msg_detail = $val->description;
            }    
        }
        
        header("cache-Control: no-store, no-cache, must-revalidate");
        header("cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
        
    }
}
