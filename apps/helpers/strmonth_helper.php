<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('strmonth'))
{      
    function strmonth($m) {
        if($m<10){
            $m = "0".$m;
        }
        return $m;                    
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

