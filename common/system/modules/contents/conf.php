<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*
 * MODULE PARAMETER
 */
define("DATABASE",false);
define("USE_SKIN",true);

define("USE_TEMPLATE",true);
$themes = array(
    '[br]'=>'<br/>',
    '\n'=>'<br/>',
    '[title]'=>'<h4><span class="underline_o">',
    '[/title]'=>'</span></h4>',
    '[p]'=>'<p>',
    '[/p]'=>'</p>',
    '[i]'=>'<i>',
    '[/i]'=>'</i>',
    '[b]'=>'<b>',
    '[/b]'=>'</b>'
);

/*
 * LANGUAGEES PARAMETERS
 */
define("DEFAULT_LANGUAGE",'fr');

?>