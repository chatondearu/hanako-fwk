<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

if( (defined('PHP_SESSION_DISABLED') && PHP_SESSION_DISABLED) || !defined('PHP_SESSION_DISABLED')){
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
date_default_timezone_set('Europe/Paris');

/*
 * ADD ALL BASIC CORE FILES TO HANAKO
 */

//autoload
require_once HANAKO_SYSTEM.'/core/autoload.php';

//load conf

//Init Header class
$hnk_headers = new header_Syteme();

function header_redirect($path) {
    global $hnk_headers;
    $hnk_headers->redirect($path);
}
function header_set($vals) {
    global $hnk_headers;
    $hnk_headers->set($vals);
}
function header_exec() {
    global $hnk_headers;
    $hnk_headers->exec();
}
function header_reset() {
    global $hnk_headers;
    $hnk_headers->reset();
}
function header_change($values) {
    header_reset();
    header_set($values);
    header_exec();
}

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
if(HANAKO_BASEROOT == '/'){ //no special path we call the default handler
    $hnk_setHandler = array(DEFAULT_CONTROL,'init');
}else{ //we have path and explode it
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
$method = $_SERVER['REQUEST_METHOD'];


define('HANDLER',$hnk_handler_dir);
define('CALLER',$hnk_caller);

//call and create controller from handler
if(file_exists(SITE_CONTROLS.'/'.HANDLER.HANAKO_EXT_PHP)){

    require_once(SITE_CONTROLS.'/'.HANDLER.HANAKO_EXT_PHP);
    $className = 'Control_'.HANDLER;
    $hnk_init_control = new $className();//We lauch control
    if(method_exists($hnk_init_control,CALLER)){
        header_change('HTTP/1.0 200 OK');
        $hnk_init_control->{CALLER}($args,$method);
    }else
        hnk_show_error(404);

}else
    hnk_show_error(404);