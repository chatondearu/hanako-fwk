<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*
 * INITIALIZATION DEFAULT TEMPLATE
 */

//Init the template Loader
$hnk_tpl = new hnk_Template();

//Functions
function mod_c($key){
    global $hnk_tpl;
    if(is_string($key))
        return $hnk_tpl->content->get_line($key);
    return false;
}