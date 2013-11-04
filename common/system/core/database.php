<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

require_once HANAKO_SYSTEM.'/conf/conf_bdd.php';

//Start database connection
$hnk_db = ( defined('BASE_TAG') && BASE_TAG )? new database_Object() : 'no database configured' ;

function hnk_getDB(){
    global $hnk_db;
    if(is_object($hnk_db) && $hnk_db->connected)
        return $hnk_db->connection;
    return false;
}