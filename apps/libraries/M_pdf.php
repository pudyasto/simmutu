<?php

/*
 * ***************************************************************
 * Script : M_pdf
 * Version : 
 * Date : Jun 11, 2017 | 7:58:52 PM
 * Author : Pudyasto Adi W.
 * Email : mr.pudyasto@gmail.com
 * Description : 
 * ***************************************************************
 */

/**
 * Description of M_pdf
 *
 * @author pudyasto
 */
require_once APPPATH . '../vendor/autoload.php';

class M_pdf {
    //put your code here
    
    function load($param=NULL)
    {    
        if ($param == NULL)
        {
            $param = '"en-GB-x","A4","","",10,10,10,10,6,3';          		
        }
         
        //return new mPDF($param);
        return new \Mpdf\Mpdf([
                'default_font_size' => 10,
                'default_font' => 'arial',
                'tempDir' => APPPATH . '/cache',
        ]);
    }
}
