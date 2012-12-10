<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

    require(HANAKO_MODULES.'/contents/conf.php');
    require(HANAKO_MODULES.'/contents/class/contents_Language.php');
    require(HANAKO_MODULES.'/contents/class/contents_Core.php');

    $mod_contents = new contents_Core($themes);

?>