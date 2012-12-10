<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');


if(isset($_GET['deco'])){
    session_destroy();
    header_redirect('home.html');
}


//Init the module Loader
$hnk_mods = new module_Init();

//get conf modules and modules alreaydy loaded
require_once HANAKO_SYSTEM.'/conf/conf_modules.php';


/* HELPERS for Connection */

function get_error_connection(){
    global $connection;
    if($connection->error){
        echo '<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Erreur</strong> Votre login ou votre mot de passe n\'est pas correct.
        </div>';
    }
}


/* HELPERS for Form */
function get_error_form(){
    global $form;
    if($form->msg){
        echo '<div class="alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Erreur</strong> '.$form->msg.'
        </div>';
    }
}


/* HELPERS for epicTwitter */
function epicTwitter_parse($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a class="link" href="$0" target="_blank" onFocus="this.blur();">$0</a>', $text);
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a class="link" href="$0" target="_blank" onFocus="this.blur();">$0</a>', $text);
    $text = preg_replace('#@([a-z0-9_]+)#i', '<a class="link" href="http://twitter.com/$1" target="_blank" onFocus="this.blur();">@$1</a>', $text);
    $text = preg_replace('# \#([a-z0-9_-]+)#i', ' <a class="link" href="http://search.twitter.com/search?q=%23$1" target="_blank" onFocus="this.blur();">#$1</a>', $text);
    return $text;
}