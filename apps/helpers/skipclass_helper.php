<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('skipclass'))
{      
    function skipclass($class) {
        switch ($class) {
            case 'main';
                $class = 'dashboard';
                break;
            case 'profile';
                $class = 'dashboard';
                break;
            case 'access';
                $class = 'dashboard';
                break;
            case 'groupaccess';
                $class = 'groups';
                break;
            case 'debug';
                $class = 'dashboard';
                break;
            default:
                break;
        }
        return $class;
    }        
}
/* 
 * Created by Pudyasto Adi Wibowo
 * Email : mr.pudyasto@gmail.com
 * pudyasto.wibowo@gmail.com
 */

