<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('daydatetime_id'))
{      
    function daydatetime_id($datetime) {
        // formate date : w, YYYY-MM-DD HH:II:SS
        $w = substr($datetime, 0, 1);
        $yyyy = substr($datetime, 3, 4);
        $mm = substr($datetime, 8, 2);
        $dd = substr($datetime, 11, 2);
        $time = substr($datetime, 14, 8);
        $hari = array(
            "Minggu",
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jum'at",
            "Sabtu",
        );
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
            return $hari[(int) $w].", ".$dd." ".$bulan[(int) $mm]." ".$yyyy." ".$time;
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

