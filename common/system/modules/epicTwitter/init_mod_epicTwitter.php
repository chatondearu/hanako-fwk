<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

    require_once HANAKO_MODULES.'/epicTwitter/conf.php';
    require_once HANAKO_MODULES.'/epicTwitter/class/OAuth.php';
    require_once HANAKO_MODULES.'/epicTwitter/class/twitteroauth.php';

    $mod_epicTwitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);