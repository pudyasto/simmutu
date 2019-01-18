<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('json_brackets'))
{      
    function json_brackets($param = array()) {
        $enc = json_encode($param);
        $res = str_replace("[","{",str_replace("]","}",$enc));
        return $res;                        
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

