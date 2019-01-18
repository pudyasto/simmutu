<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('jual_bersih'))
{      
    function jual_bersih($subtotal,$diskon = 0,$diskonpersen = 0){
        $result = $subtotal - ($diskon + ($subtotal*($diskonpersen/100)));
        return $result;    
    }
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

