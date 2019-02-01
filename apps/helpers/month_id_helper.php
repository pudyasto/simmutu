<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('month_id'))
{      
    function month_id($yyyymm) {
        // formate date : YYYY-MM-DD
        $dt = explode("-", $yyyymm);
        $yyyy = $dt[0];
        $mm = (int) $dt[1];
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
            return $bulan[$mm]." ".$yyyy;
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

