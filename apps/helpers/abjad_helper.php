<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('abjad'))
{      
    function abjad($urut) {
        // formate date : YYYY-MM-DD
        $angka = (int) $urut;
        $abjad = array(
            '',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'Q',
            'R',
            'S',
            'T',
            'U',
            'V',
            'W',
            'X',
            'Y',
            'Z',
        );
        
        if ($angka == 0 || is_numeric($angka) == false) {
            return ' Angka Tidak Valid ';
        }
        elseif ($angka <= 26) {
            return $abjad[$angka];
        }  
        else {
            return ' Angka Salah ';
        }                     
    }     
    
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

