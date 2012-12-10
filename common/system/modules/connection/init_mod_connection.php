<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

    require(HANAKO_MODULES.'/connection/conf.php');
    require(HANAKO_MODULES.'/connection/class/connection_Core.php');

    $mod_connection = new connection_Core();