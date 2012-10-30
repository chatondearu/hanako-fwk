<?php

//functions environement
function here(){
    $me = preg_replace('`'.LOCAL_PATH.'`','',$_SERVER['REQUEST_URI']);
    $me = explode("?",$me);
    $me = $me[0];
    return $me;
}
function way(){
    $way = null;
    for($i=0 ; $i < sizeof( explode(SEPARATOR_REALPATH,realpath('.')) ) - sizeof( explode(SEPARATOR_REALPATH,dirname(__DIR__)) ); $i++){
        $way .= '../';
    }
    return $way;
}

/// Path Links
define('WAY_PATH',way());
define('HERE',here());

define("LIB_PATH",WAY_PATH."lib/php/");
define("LIB_JS_PATH",WAY_PATH."lib/js/");

define("MODULES_PATH",WAY_PATH."modules/");

define("MODELS_PATH", WAY_PATH."models/");

define("PAGES_PATH", WAY_PATH."pages/");
define("CONTROLS_PATH", PAGES_PATH."controls/");
define("JS_PATH", PAGES_PATH."js/");
define("VIEWS_PATH", PAGES_PATH."views/");

define("RESS_PATH", WAY_PATH."resources/");

define("COMMON_PATH", RESS_PATH."common/");
define("CSS_COMMON_PATH", COMMON_PATH.'css/');
define("IMG_COMMON_PATH", COMMON_PATH.'img/');

define("SKINS_PATH", RESS_PATH."skins/".SKIN."/");
define("CSS_SKINS_PATH", SKINS_PATH.'css/');
define("IMG_SKINS_PATH", SKINS_PATH.'img/');

define("SERVICES_PATH", WAY_PATH.'services/');
define("AJAX_PATH", SERVICES_PATH.'ajax/');

define("TOOLS_PATH",WAY_PATH."outils/");
define("TOOLS_PHP_PATH", TOOLS_PATH."php/");


/// Librarys version
define("JQUERY","jquery/jquery-1.7.1.min.js");
define("JQUERYUI","1.8.18.custom");

///Constante environement
define("FORMAT_DATE_BDD",'Y-m-d H:i:s');