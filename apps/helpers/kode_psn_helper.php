<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('kode_psn'))
{      
    function kode_psn($kode_psn) {
        if(strlen($kode_psn)===12){
            // formate date : 99-99-999999
            $dt = explode("-", $kode_psn);
            $kode = $dt[2];
            $a = substr($kode, 0, 2);
            $b = substr($kode, 2, 2);
            $c = substr($kode, 4, 2);
            return $a.' - '.$b.' - '.$c;
        }else{
            return "KODE SALAH!";
        }
        
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

