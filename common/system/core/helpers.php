<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/**
 * PATH GETTER
 */


/**
 * HTML GENERATEUR
 */

function gen_style($path,$medias='screen'){
    if(file_exists($path)){
        return '<link href="'.$path.'" rel="stylesheet" media="'.$medias.'"/>';
    }elseif(DEBUG) return 'ERROR ::: no stylesheet at '.$path;
    return false;
}

function gen_script($path,$async=false){
    if(file_exists($path)){
        return '<script src="'.$path.'" language="javascript" type="text/javascript" '.(($async)?'async':null).'></script>';
    }elseif(DEBUG) return 'ERROR ::: no script at '.$path;
    return false;
}

function gen_img($path,$alt='image'){
    if(file_exists($path)){
        return '<img src="'.$path.'" alt='.$alt.'/>';
    }elseif(DEBUG) return 'ERROR ::: no script at '.$path;
    return false;
}
