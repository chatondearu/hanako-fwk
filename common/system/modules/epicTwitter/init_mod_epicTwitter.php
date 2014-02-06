<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

    require_once HANAKO_MODULES.'/epicTwitter/conf.php';
    require_once HANAKO_MODULES.'/epicTwitter/class/EpiCurl.php';
    require_once HANAKO_MODULES.'/epicTwitter/class/EpiOAuth.php';
    require_once HANAKO_MODULES.'/epicTwitter/class/EpiTwitter.php';

    $mod_epicTwitter = new EpiTwitter(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);