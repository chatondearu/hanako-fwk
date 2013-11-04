<!DOCTYPE html>
<html itemscope itemtype=http://schema.org/<?php echo hnk_tpl('schema')?>>
    <head>
        <title><?php echo hnk_tpl('title')?></title>
        <!--<base href="<?php echo URL; ?>" target="_self"/>-->
        <meta charset="<?php echo SITE_CHARSET?>">

        <meta itemprop="name" name="name" content="<?php echo hnk_tpl('name')?>">
        <meta itemprop="description" name="description" content="<?php echo hnk_tpl('description')?>">
        <meta name="keywords" content="<?php echo hnk_tpl('keywords')?>">
        <meta itemprop="image" name="image" content="<?php echo hnk_tpl('image')?>">

        <!-- Google -->
        <meta name="google" content="notranslate" />
        <meta name="google-site-verification" content="..." />

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable = no">

        <link rel="apple-touch-startup-image" href="<?php echo hnk_tpl_comp('path.favicon')?>/chargement.png" />
        <!-- Favicons -->
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo hnk_tpl_comp('path.favicon')?>/favicon.ico" />
        <!-- iOS device -->
        <link rel="apple-touch-icon" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-precomposed.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-72x72-precomposed.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo hnk_tpl_comp('path.favicon')?>/apple-touch-icon-114x114-precomposed.png" />

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
        <?php echo hnk_tpl('contents')?>

        <?php echo hnk_tpl_comp('scripts.bottom')?>
    </body>
</html>