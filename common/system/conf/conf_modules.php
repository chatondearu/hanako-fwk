<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*
 * INITIALIZATION DEFAULT MODULES
 */

//form module
$hnk_mods->require_mod('form');
$form = $hnk_mods->get('form');

//connection module
$hnk_mods->require_mod('connection');
$connection = $hnk_mods->get('connection');

//contents module
$hnk_mods->require_mod('contents');

$hnk_mods->require_mod('gravatar');
$gravatar = $hnk_mods->get('gravatar');