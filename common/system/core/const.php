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
define("HANAKO_MODELS",HANAKO_SYSTEM."/db_models");
define("HANAKO_TEMPLATE",HANAKO_SYSTEM."/templates");

define("SITE_CONTENTS", HANAKO_SITE."/contents");
define("SITE_MODELS", HANAKO_SITE."/models");
define("SITE_CONTROLS", HANAKO_SITE."/controls");
define("SITE_VIEWS", HANAKO_SITE."/views");
define("SITE_RESS", HANAKO_SITE."/resources");
define("SITE_JS", SITE_RESS."/js");

define("SRC_COMMON",HANAKO_SRC."/common");
define("SRC_SKINS",HANAKO_SRC."/skins/".DEFAULT_SKIN);
define("SRC_SCRIPTS",HANAKO_SRC."/js");
define("SRC_FAVICON",SRC_COMMON."/favicon");
define("SRC_IMG",SRC_COMMON."/img");
define("SRC_CSS",SRC_COMMON."/css");

define("SRC_HTTP_COMMON",HANAKO_HTTP_SRC."/common");
define("SRC_HTTP_SKINS",HANAKO_HTTP_SRC."/skins/".DEFAULT_SKIN);
define("SRC_HTTP_SCRIPTS",HANAKO_HTTP_SRC."/js");
define("SRC_HTTP_FAVICON",SRC_HTTP_COMMON."/favicon");
define("SRC_HTTP_IMG",SRC_HTTP_COMMON."/img");
define("SRC_HTTP_CSS",SRC_HTTP_COMMON."/css");

/// Librarys version
define("JQUERY_VERSION","1.7.1.min");
define("JQUERY","jquery/jquery-".JQUERY_VERSION.".js");
define("ANGULAR","angular/angular.js");
define("ANGULAR_RESOURCE","angular/angular-resource.js");
define("MD5","jshash/md5-min.js");
define("UNDERSCORE","underscore/underscore.js");
define("MODERNIZR_VERSION","custom.07465");
define("MODERNIZR","modernizr/modernizr.".MODERNIZR_VERSION.".js");


define("JELLYBOOT", "http://labo.rlienard.fr/jellyboot");

define("JQUERYUI","1.8.18.custom");

define("DATA_IP_USER",$_SERVER['REMOTE_ADDR']);
