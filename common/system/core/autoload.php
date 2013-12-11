<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

function classLoaderFromLib($className) {

        // set nomenclatured path
    $path = preg_replace('/^([a-z]*)_/', '$1/$1_', $className);

        //get
    if(file_exists( HANAKO_LIB.'/'.$path.HANAKO_EXT_PHP)){
        require_once( HANAKO_LIB.'/'.$path.HANAKO_EXT_PHP);
    }elseif(file_exists( HANAKO_MODULES.'/'.$path.HANAKO_EXT_PHP)){
        require_once( HANAKO_MODULES.'/'.$path.HANAKO_EXT_PHP);
    }elseif(file_exists( SITE_MODELS.'/'.$className.HANAKO_EXT_PHP)){
        require_once( SITE_MODELS.'/'.$className.HANAKO_EXT_PHP);
    }elseif(file_exists( HANAKO_MODELS.'/'.$className.HANAKO_EXT_PHP)){
        require_once( HANAKO_MODELS.'/'.$className.HANAKO_EXT_PHP);
    }elseif(file_exists( HANAKO_SYSTEM.'/core/'.$className.HANAKO_EXT_PHP)){
        require_once( HANAKO_SYSTEM.'/core/'.$className.HANAKO_EXT_PHP);
    }elseif(file_exists( $className.HANAKO_EXT_PHP)){
        require_once( $className.HANAKO_EXT_PHP);
    }else{
        if(DEBUG){
            echo 'pas de class pour '.$className.' à '.$path;
        }
    }

}
spl_autoload_register('classLoaderFromLib');
