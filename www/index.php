<?php


/*
 * CONFIGURATION MODE
 * */


// Use HTTP Strict Transport Security to force client to use secure connections only
$use_sts = true;

define("DEBUG",true);

define('CONSTRUCTION_PAGE','construction.html');

/* Administrateur */
define('WEBMASTER','postmaster@domain.fr');


/*
 * SITE
 * */

//if you using DataBase set the name of Base here else set BASE_TAG has false
define('BASE_TAG',false);
//define('BASE_TAG','hanako');

define('BASEROOT','/');

define('HANAKO_SYSTEM','../common/system');

define('HANAKO_SITE','../common/sites/www');

define('HANAKO_HTTP_SRC','http://src.domain.fr');
define('HANAKO_SRC','../sources');

//You can't use "index" has default
define('DEFAULT_CONTROL','home');

/* custom */
define('DEFAULT_SKIN','default');
define('SITE_CHARSET','utf-8');


/*
* SETTINGS HANAKO
* Don't touch if you don't need changes here
*/

//TODO faire un module de gestion des CSP
//header("Content-Security-Policy: default-src 'self' http://src.rlienard.fr http://*.rlienard.fr http://rlienard.fr; script-src 'self' https://apis.google.com http://platform.twitter.com  https://api.twitter.com https://plusone.google.com https://clients6.google.com http://src.rlienard.fr; img-src 'self' http://*.rlienard.fr");

if(DEFAULT_CONTROL == 'index') exit('You can\'t use "index" has default value for DEFAULT_CONTROL in your index file');

//set Globals
define("HOST",$_SERVER['HTTP_HOST']);
define("TLD",substr(HOST, strrpos(HOST, ".")+1));
define("URL",'http://'.HOST.BASEROOT);

// Is the system path correct?
if ( ! is_dir(HANAKO_SYSTEM))
    exit('Hanako n\'a pas été trouvé, verifiez HANAKO_SYSTEM');

define("URI", $_SERVER['SCRIPT_NAME']);
define("SITE",HOST.BASEROOT);

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('EXT', '.html');
define("QUERY",$_SERVER['QUERY_STRING']);


if(!defined("PHP_SESSION_DISABLED")){
    if (!isset($_SESSION)) {
        define("PHP_SESSION_DISABLED",true);
    }else{
        define("PHP_SESSION_DISABLED",false);
    }
}

//Launch hanako
require_once(HANAKO_SYSTEM.'/core/Hanako.php');