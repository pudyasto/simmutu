<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('label_barcode'))
{      
    function label_barcode($barcode="000000000000000"){
        $dt = array();
        for($i=0;$i<=strlen($barcode);$i++){
            array_push($dt,substr($barcode,$i,1));
        }
        $res = "";
        foreach ($dt as $value) {
            $res .= $value . " ";
        }
        return $res;                
    }        
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

