<?php
/**
 * Created by JetBrains PhpStorm.
 * User: romainlienard
 * Date: 06/11/11
 * Time: 00:13
 * To change this template use File | Settings | File Templates.
 */

function classLoaderFromLib($className) {
    $path = preg_replace('/^([a-z]*)_/', '$1/class/$1_', $className);
    if(file_exists( LIB_PATH.$path.'.php')){
        require_once( LIB_PATH.$path.'.php');
    }elseif(file_exists( MODELS_PATH.$path.'.member.php')){
        require_once( MODELS_PATH.$path.'.member.php');
    }elseif(file_exists( MODELS_PATH.$path.'.collection.php')){
        require_once( MODELS_PATH.$path.'.collection.php');
    }elseif(file_exists( MODELS_PATH.$path.'.php')){
        require_once( MODELS_PATH.$path.'.php');
    }elseif(file_exists( $className.'.php')){
        require_once( $className.'.php');
    }else{
        if(DEBUG){
            echo 'pas de class pour '.$className.' à '.$path;
        }
    }

}
spl_autoload_register('classLoaderFromLib');

?>