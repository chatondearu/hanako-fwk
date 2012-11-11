<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

//Init the module Loader
$hnk_mods = new module_Init();

//get conf modules and moudles alreaydy loaded
include_once HANAKO_SYSTEM.'/conf/conf_modules.php';