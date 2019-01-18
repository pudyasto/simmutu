<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('datetime_id'))
{      
    function datetime_id($datetime) {
        // formate date : YYYY-MM-DD HH:II:SS
        $yyyy = substr($datetime, 0, 4);
        $mm = substr($datetime, 5, 2);
        $dd = substr($datetime, 8, 2);
        $time = substr($datetime, 11, 8);
        $bulan = array(
            '',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        );
        
        if ($mm == 0 || is_numeric($mm) == false) {
            return 'Bulan Tidak Valid ';
        }
        elseif ($mm <= 12) {
            return $dd." ".$bulan[(int) $mm]." ".$yyyy." ".$time;
        }  
        else {
            return "Format Tanggal Tidak Valid";
        }                     
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

