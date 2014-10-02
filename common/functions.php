<?php
define('__ROOT__', dirname(__FILE__));
$config = include (__ROOT__.'/conf/conf.php');

function C( $param ) {
    global $config;
    if( !empty($config[$param]) ) {
        $ret = $config[$param];            
        return $ret;
    }
    
    return false;      
}

