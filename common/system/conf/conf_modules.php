<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*
 * INITIALIZATION MODULES
 */
//connection module
$mods->require_mod('connection');
//contents module
$mods->require_mod('contents');
$mod_contents = $mods->get('contents');