<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

if(PHP_SESSION_DISABLED){
    session_start();
}

require_once(HANAKO_SYSTEM.'/core/generated.php');
getGeneratedTime('start');

//Including const
require_once(HANAKO_SYSTEM.'/core/const.php');


/*
 * SETTINGS PHP
 */

//set PHP values
ini_set('display_errors', 1);
ini_set('error_reporting', 2047);
ini_set('include_path','.:'.SITE);

/*
 * ADD ALL BASIC CORE FILES TO HANAKO
 */
//Init Header class
require_once HANAKO_LIB.'/Header.php';

//autoload
require_once HANAKO_SYSTEM.'/core/autoload.php';

//load conf


//Including Core function

//Start database connection
if( defined('BASE_TAG') && BASE_TAG )
    require_once HANAKO_SYSTEM.'/core/database.php';
//Start module gesture
require_once HANAKO_SYSTEM.'/core/modules.php';
//Init template system and functions.
require_once HANAKO_SYSTEM.'/core/template.php';
//Get All Helpers functions
require_once HANAKO_SYSTEM.'/core/helpers.php';

/**
 * hnk_show_error()
 */
function hnk_show_error($set){
    $pth='error/error-'.$set.'.html';
    if(is_numeric($set)
        && $set > 399
        && $set < 504
        && file_exists($pth)
    ){
        header_change(array('Status' =>$set.' not found'));
        include 'error/error-'.$set.'.html';
        exit();
    }
}



/*
 * PARSE DATA IN URI AND CONSTRUCT PAGE WITH CONTROLER
 */



//search controller calling

/*
 * Model de référence url : control/method/variables/../../..
 * Model de référence url : dir/dir/control/method/variables/../../..
 */

//get path called to set handler
if(HANAKO_BASEROOT == '/') //no special path we call the default handler
    $hnk_setHandler = array(DEFAULT_CONTROL,'init');
else{ //we have path and explode it
    $hdl = explode('/',str_replace(EXT,'',HANAKO_BASEROOT));
    array_shift($hdl);
    $hnk_setHandler =$hdl;
}

$hnk_handler_dir=$hnk_setHandler[0];

//parcour handler context and search control reference
for($i=1,$l=sizeof($hnk_setHandler);$i<$l;$i++){
    //context is dir ?
    if(is_dir(SITE_CONTROLS.'/'.$hnk_handler_dir))
        $hnk_handler_dir .= '/'.$hnk_setHandler[$i];
    else break;
}//we have the real path to call handler

//we init the method of handler if exist or set 'init' by default
$hnk_caller = array_key_exists($i,$hnk_setHandler)? basename($hnk_setHandler[$i],EXT):'init';

$args = Array();
//parcour handler context and search arguments
for($i++,$l=sizeof($hnk_setHandler);$i<$l;$i++){
    //context is dir ?
    $args[] = $hnk_setHandler[$i];
}


define('HANDLER',$hnk_handler_dir);

//call and create controller from handler
if(file_exists(SITE_CONTROLS.'/'.HANDLER.HANAKO_EXT_PHP)){

    require_once(SITE_CONTROLS.'/'.HANDLER.HANAKO_EXT_PHP);
    $className = 'Control_'.HANDLER;
    $hnk_init_control = new $className();//We lauch control
    if(method_exists($hnk_init_control,$hnk_caller)){
        header_change('HTTP/1.0 200 OK');
        $hnk_init_control->{$hnk_caller}($args);
    }else
        hnk_show_error(404);

}else
    hnk_show_error(404);