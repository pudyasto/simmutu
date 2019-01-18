<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('month'))
{      
    function month($int) {
        $angka = (float) $int;
        $bilangan = array(
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
            'Penutupan'
        );
        
        if ($angka == 0 || is_numeric($angka) == false) {
            return 'Angka Tidak Valid ';
        }
        elseif ($angka <= 13) {
            return $bilangan[$angka];
        }                      
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

