<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

$hnk_tpl_component = array(
    'path' => array(
        'favicon'=>SRC_FAVICON.'/www'
    ),
    'styles' => array(
        gen_style(SRC_CSS.'/core.css')
    ),
    'scripts' => array(
       'top' => array(
           gen_script(SRC_SCRIPTS.'/'.JQUERY,true)
        ),
        'async' => array(
            gen_script(SRC_SCRIPTS.'/'.DEFAULT_SKIN.'/css/global.css')
        ),
        'bottom' => array(
            gen_script(SRC_SCRIPTS.'/'.DEFAULT_SKIN.'/css/global.css')
        )
    )
);