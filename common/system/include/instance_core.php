<?php

//Start database connection
$db = new database_DatabaseObject();

//Start module gesture
$mods = new module_Init();


/*
 * INITIALIZATION MODULES
 */
    //connection module
    $mods->require_mod('connection');
    //contents module
    $mods->require_mod('contents');
    $mod_contents = $mods->get('contents');
