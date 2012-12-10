<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');
/**
 * Configuration du module "connection"
 */

define("__CONNECT_IFTYPE",true);

define("__CONNECT_USERNAME_CONTEXT",':required:trim:alphanumeric:');
define("__CONNECT_PASSWORD_CONTEXT",':required:trim:alphanumeric:');
//methode de heshage utilisé à laquel l'on rajoute un hash en md5
define("__CONNECT_CRYPT_METHOD","whirlpool");
define("__CONNECT_RETURN_LOCATION", 'home.html' );