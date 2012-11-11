<?php


/*
 * CONFIGURATION MODE
 * */

define("DEBUG",false);

define('CONSTRUCTION_PAGE','construction.html');

/* Administrateur */
define('WEBMASTER','rlienard@web-softcity.com');


/*
 * SITE
 * */

//if you using DataBase set the name of Base here else set BASE_TAG has false
define('BASE_TAG',false);
//define('BASE_TAG','hanako_3');

define('BASEROOT','/www');

define('HANAKO_SYSTEM','../common/system');

define('HANAKO_SITE','../common/sites/www');

define('HANAKO_SRC','../sources');

//You can't use "index" has default
define('DEFAULT_CONTROL','home');

/* custom */
define('DEFAULT_SKIN','default');
define('SITE_CHARSET','UTF-8');


/*
* SETTINGS HANAKO
* Don't touch if you don't need changes here
*/

if(DEFAULT_CONTROL == 'index') exit('You can\'t use "index" has default value for DEFAULT_CONTROL in your index file');

//set Globals
define("HOST",$_SERVER['HTTP_HOST']);
define("URL",'http://'.HOST);

// Is the system path correct?
if ( ! is_dir(HANAKO_SYSTEM))
    exit('Hanako n\'a pas été trouvé, verifiez HANAKO_SYSTEM');

define("URI", $_SERVER['SCRIPT_NAME']);
define("SITE",HOST.URI);

define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('EXT', '.html');
define("QUERY",$_SERVER['QUERY_STRING']);


//Launch hanako
include_once(HANAKO_SYSTEM.'/core/Hanako.php');