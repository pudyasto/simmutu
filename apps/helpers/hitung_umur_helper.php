<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('hitung_umur'))
{      
    function hitung_umur($param,$param2 = null,$format = 'Ymd'){
        $date1 = new DateTime(date('Y-m-d', strtotime($param)));
        if(empty($param2)){
            $date2 = new DateTime(date('Y-m-d'));
        }else{
            $date2 = new DateTime(date($param2));
        }
        
        $interval = $date1->diff($date2);
        if($format=='num'){
            return $interval->y . "," . $interval->m.",".$interval->d;
        }elseif($format=='Ymd'){
            return $interval->y . " Tahun " . $interval->m." Bulan ".$interval->d." Hari ";
        }elseif($format=='Ym'){
            return $interval->y . " Tahun " . $interval->m." Bulan ";
        }elseif($format=='Y'){
            return $interval->y . " Tahun ";
        }else{
            return $interval->y . " Tahun " . $interval->m." Bulan ".$interval->d." Hari ";
        }
    }
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

