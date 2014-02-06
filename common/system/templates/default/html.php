<!DOCTYPE html>
<html itemscope itemtype=http://schema.org/<?php echo hnk_tpl('schema')?> lang='<?php echo __LANGUAGE?>'>
    <head>
        <title><?php echo hnk_tpl('title')?></title>
        <!--<base href="<?php echo URL; ?>" target="_self"/>-->
        <meta charset="<?php echo SITE_CHARSET?>">

        <meta itemprop="name" name="name" content="<?php echo hnk_tpl('name')?>">
        <meta itemprop="description" name="description" content="<?php echo hnk_tpl('description')?>">
        <meta name="keywords" content="<?php echo hnk_tpl('keywords')?>">
        <meta itemprop="image" name="image" content="<?php echo hnk_tpl('image')?>">

        <?php if(CALLER != 'outdate'){ ?>
        <!--[if lt IE 9]>
            <meta http-equiv="refresh" content="0;URL='<?php echo URL; ?>outdate'">
        <![endif]-->
        <?php } ?>

        <!-- Google -->
        <meta name="google" content="notranslate" />
        <meta name="google-site-verification" content="..." />

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable = no">

        <link rel="apple-touch-startup-image" href="<?php echo hnk_tpl_comp('path.favicon')?>/chargement.png" />
        <!-- Favicons -->
        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-152x152.png">
        <link rel="icon" type="image/png" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon-196x196.png" sizes="196x196">
        <link rel="icon" type="image/png" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon-160x160.png" sizes="160x160">
        <link rel="icon" type="image/png" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon-16x16.png" sizes="16x16">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="<?php echo hnk_tpl_comp('path.favicon')?>/mstile-144x144.png">
        <link rel="canonical" href="<?php echo URL?>">

        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!--Ressources Ress-->
        <?php echo hnk_tpl_comp('styles')?>
        <?php echo hnk_tpl('style')?>

        <!--Ressources Locale-->

        <?php echo hnk_tpl_comp('scripts.top')?>

    </head>
    <body class="preload">
        <noscript>
            Pour accéder à toutes les fonctionnalités de ce site, vous devez activer JavaScript.
            Voici les <a href="http://www.enable-javascript.com/fr/" target="_blank">
            instructions pour activer JavaScript dans votre navigateur Web</a>.
        </noscript>
        <?php echo hnk_tpl('contents')?>

        <?php echo hnk_tpl_comp('scripts.bottom')?>
    </body>
</html>