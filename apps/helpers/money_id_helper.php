<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('money_id'))
{      
    function money_id($money) {
        $m = (float) $money;
        if($m<0){
            return "(".number_format(abs($m), 2).")";
        }else{
            return number_format($m, 2);
        }
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

