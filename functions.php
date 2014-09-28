<?php
$config = include ('conf.php');

function C( $param ) {
        global $config;
        if( !empty($config[$param]) ) {
                $ret = $config[$param];            
                return $ret;
        }
        
        return false;      
}

