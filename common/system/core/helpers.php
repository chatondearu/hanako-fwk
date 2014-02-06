<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/**
 * FUNCTIONS
 */

    include_once HANAKO_LIB.'/DataUri'.HANAKO_EXT_PHP;

    include_once HANAKO_LIB.'/SecurAjaxServices'.HANAKO_EXT_PHP;

/**
 * PATH GETTER
 */

    /* Gravatar module */
    function getGravatar($mail,$size=64){
        global $gravatar;
        $gravatar->setEmail($mail)->setSize($size)->setRatingAsPG()->setImage('http://src.rlienard.fr/common/img/shape/me_shape.png');
        return $gravatar->getAvatar();
    }

/**
 * HTML GENERATEUR
 */

function gen_style($path,$medias='screen'){
    if(is_string($path)){
        return '<link href="'.$path.'" rel="stylesheet" media="'.$medias.'"/>';
    }elseif(DEBUG) return 'ERROR ::: no string ::: '.$path;
    return false;
}

function gen_script($path,$async=false){
    if(is_string($path)){
        return '<script src="'.$path.'" type="text/javascript" '.(($async)?'async':null).'></script>';
    }elseif(DEBUG) return 'ERROR ::: no string ::: '.$path;
    return false;
}

function gen_img($path,$attr=array('alt'=>null), $isData=false){
    if(is_string($path)){
        if( !array_key_exists('alt',$attr) || is_null($attr['alt'])) $attr['alt'] = basename($path);
        if($isData)$path = data_uri($path,'image/png');
        $tag_img = '<img src="'.$path.'" ';
        foreach($attr as $name=>$value){
            $tag_img .= $name.'="'.$value.'" ';
        }
        $tag_img.=' />';
        return $tag_img;
    }elseif(DEBUG) return 'ERROR ::: no string ::: '.$path;
    return false;
}
