<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

include_once HANAKO_SYSTEM.'/conf/conf_bdd.php';

//Start database connection
$hnk_db = new database_DatabaseObject();