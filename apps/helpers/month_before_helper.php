<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('month_before'))
{      
    function month_before($month,$plusminus = -1) {
        // yyyy-mm
        $Ymd = $month."-01";
        $res = date('Y-m',strtotime ( $plusminus.' month' , strtotime ( $Ymd ) ));                      
        return $res;
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

