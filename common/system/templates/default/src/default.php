<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

$hnk_tpl_component = array(
    'path' => array(
        'favicon'=>SRC_HTTP_FAVICON.'/www'
    ),
    'styles' => array(
        gen_style(SRC_HTTP_SKINS.'/css/global.css'),
        gen_style(SRC_HTTP_SKINS.'/css/'.HANDLER.'.css')
    ),
    'scripts' => array(
        'top' => array(
           gen_script(SRC_HTTP_SCRIPTS.'/'.JQUERY,false),
           gen_script(SRC_HTTP_SCRIPTS.'/global.js',false)
        ),
        'bottom' => array()
    )
);