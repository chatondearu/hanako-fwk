<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

include_once(HANAKO_SYSTEM.'/core/generated.php');
getGeneratedTime('start');

//Including const
include_once(HANAKO_SYSTEM.'/core/const.php');


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

//autoload
include_once HANAKO_SYSTEM.'/core/autoload.php';

//load conf


//Including Core function

//Start database connection
if( defined('BASE_TAG') && BASE_TAG )
    include_once HANAKO_SYSTEM.'/core/database.php';
//Start module gesture
include_once HANAKO_SYSTEM.'/core/modules.php';
//Init template system and functions.
include_once HANAKO_SYSTEM.'/core/template.php';
//Get All Helpers functions
include_once HANAKO_SYSTEM.'/core/helpers.php';

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
        header('HTTP/1.0 '.$set.' not found');
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
        $hdl = explode('/',HANAKO_BASEROOT);
        array_shift($hdl);
        $hnk_setHandler =$hdl;
    }

    $hnk_handler_dir=$hnk_setHandler[0];

    //parcour handler context and search control reference
    for($i=1,$l=sizeof($hnk_setHandler);$i<$l;$i++){
        //context is dir ?
        if(is_dir(SITE_CONTROLS.'/'.$hnk_handler_dir))
            $hnk_handler_dir .= '/'.basename($hnk_setHandler[$i],EXT);
        else break;
    }//we have the real path to call handler

    //we init the name of handler called
    $hnk_handler= basename($hnk_setHandler[$i-1]);

    //we init the method of handler if exist or set 'init' by default
    $hnk_caller = array_key_exists($i,$hnk_setHandler)? basename($hnk_setHandler[$i],EXT):'init';

    //call and create controller from handler
    if(file_exists(SITE_CONTROLS.'/'.$hnk_handler_dir.HANAKO_EXT_PHP)){

        require_once(SITE_CONTROLS.'/'.$hnk_handler_dir.HANAKO_EXT_PHP);
        $hnk_init_control = new Controller();//We lauch control
        $hnk_init_control->{$hnk_caller}();

    }else
        hnk_show_error(404);