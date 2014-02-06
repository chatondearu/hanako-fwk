<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*
 * INITIALIZATION DEFAULT TEMPLATE
 */

//Init the template Loader
$hnk_tpl = new hnk_Template();

function hnk_tpl($name){
    global $hnk_tpl;
    $value = $hnk_tpl->get($name);
    if(!is_array($value))
        return $hnk_tpl->get($name);
    return false;
}

function hnk_tpl_comp($name){
    global $hnk_tpl;

    if(is_string($name)){
        $compo = $hnk_tpl->ref_compo;
        $way = (stripos($name,'.'))? preg_split('/\./',$name):array($name);

        foreach($way as $val){
            if(array_key_exists($val,$compo)){
                if(is_string($compo[$val])){
                    $compo = $compo[$val];
                    break;
                }elseif(is_array($compo[$val]))
                    $compo = $compo[$val];
            }
        }

        if(is_string($compo))
            return $compo;
        elseif(is_array($compo) ){
            return join("\n",$compo);
        }
    }
    return false;
}

//Functions
function mod_c($key){
    global $hnk_tpl;
    if(is_string($key))
        return $hnk_tpl->content->get_line($key);
    return false;
}