<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

define('HANAKO_VERSION','2.5.5');

/*
 * Core constants
 */
$hnk__path = "/";
$hnk__path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $hnk__path;
$hnk__path = isset($_SERVER['ORIG_PATH_INFO']) ? $_SERVER['ORIG_PATH_INFO'] : $hnk__path;
define('HANAKO_BASEROOT',$hnk__path);


define('HANAKO_EXT_PHP','.php');

define("HANAKO_LIB",HANAKO_SYSTEM."/lib");
define("HANAKO_MODULES",HANAKO_SYSTEM."/modules");
define("HANAKO_TEMPLATE",HANAKO_SYSTEM."/templates");

define("SITE_CONTENTS", HANAKO_SITE."/contents");
define("SITE_MODELS", HANAKO_SITE."/models");
define("SITE_CONTROLS", HANAKO_SITE."/controls");
define("SITE_VIEWS", HANAKO_SITE."/views");
define("SITE_RESS", HANAKO_SITE."/resources");
define("SITE_JS", SITE_RESS."/js");

define("SRC_COMMON",HANAKO_SRC."/common");
define("SRC_SKINS",HANAKO_SRC."/skins");
define("SRC_SCRIPTS",HANAKO_SRC."/js");
define("SRC_FAVICON",SRC_COMMON."/favicon");
define("SRC_IMG",SRC_COMMON."/img");
define("SRC_CSS",SRC_COMMON."/css");

/// Librarys version
define("JQUERY","jquery/jquery-1.7.1.min.js");
define("JQUERYUI","1.8.18.custom");
