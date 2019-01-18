<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * ***************************************************************
 *  Script : 
 *  Version : 
 *  Date :
 *  Author : Pudyasto Adi W.
 *  Email : mr.pudyasto@gmail.com
 *  Description : Module ini hanya untuk menampilkan data secara public seperti 
 *                  referensi provinsi, kabupaten, kecamatan, kelurahan dan lainnya
 * ***************************************************************
 */

/**
 * Description of R_data
 *
 * @author adi
 */
class R_data extends CI_Controller {
    protected $data = '';
    protected $val = '';
    
    public function __construct(){
        parent::__construct();
        $this->load->model('r_data_qry');
    }
    
    public function index(){
        $this->load->view('index', $this->data, false);
    }
}
