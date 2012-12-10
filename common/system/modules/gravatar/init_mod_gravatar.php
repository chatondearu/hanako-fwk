<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

    require_once HANAKO_MODULES.'/gravatar/conf.php';
    require_once HANAKO_MODULES.'/gravatar/class/Gravatar.php';

    $mod_gravatar = new Gravatar();

////////////USE
/*
    <?php

        $mod_gravatar->setEmail('adam@talkphp.com')->setSize(80)->setRatingAsPG()->setDefaultImageAsIdentIcon();

    ?>
    <img src="<?php echo $mod_gravatar->getAvatar(); ?>" />
*/