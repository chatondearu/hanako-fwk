<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

require_once HANAKO_SYSTEM.'/conf/conf_bdd.php';

//Start database connection
$hnk_db = new database_Object();

function hnk_getDB(){
    global $hnk_db;
    if($hnk_db->connected)
    return $hnk_db->connection;
}