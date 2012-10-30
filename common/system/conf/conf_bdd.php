<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/// Connection BDD constantes

define("DATABASE_SERVER","localhost");
define("DATABASE_LOGIN","root");
define("DATABASE_PASSWORD","");

/* "mysql" "postgre" "msServer" */
define("DATABASE_TYPE","mysql");
define("DATABASE_CHAR_SEPARATOR","_");

define("BASE_TAG","hanako_");

///Constante environement
define("FORMAT_DATE_BDD",'Y-m-d H:i:s');