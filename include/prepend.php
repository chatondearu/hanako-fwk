<?php

// Ouverture de la session utilisateur
session_start();

/*
 * Include des fichiers de configuration
 */

include ('conf.php');

// Constante de l'environement
include ('include/const.php');
// Récupération des classe membres ou autre automatiquement
include ('include/autoload.php');
// Initialisation et Connection à la base de données
include ('include/instance_core.php');


/*
 * Configuration et Préparation de l'environement
 */

/*
 * Redirection vers page "en construction" si DEBUG à 'true' et utilisateur différent de Admin.
 */
if(DEBUG && $_SERVER["REMOTE_ADDR"] != ADMIN_IP){
    header('location: '.CONSTRUCTION_PAGE);
}


/*
 * Inclusion de ressources html (Header si besoin)
 */

if( PAGE ){

    if(file_exists(CONTROLS_PATH.PAGE.'.php'))
        include (CONTROLS_PATH.PAGE.'.php');
    include ('include/html_prepend_front.php');
    
}
?>