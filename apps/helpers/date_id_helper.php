<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('date_id'))
{      
    function date_id($yyyymmdd) {
        // formate date : YYYY-MM-DD
        $dt = explode("-", $yyyymmdd);
        $yyyy = $dt[0];
        $mm = (int) $dt[1];
        $dd = $dt[2];
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
            return $dd." ".$bulan[$mm]." ".$yyyy;
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

