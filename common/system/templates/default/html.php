<!DOCTYPE html>
<html itemscope itemtype=http://schema.org/<?=hnk_tpl('schema')?>>
    <head>

        <title><?=hnk_tpl('title')?></title>
        <!--<base href="<?=URL; ?>" target="_self"/>-->
        <meta http-equiv="Content-Type" Content="text/html; charset=<?=SITE_CHARSET?>">

        <meta itemprop="name" name="name" content="<?=hnk_tpl('name')?>">
        <meta itemprop="description" name="description" content="<?=hnk_tpl('description')?>">
        <meta name="keywords" content="<?=hnk_tpl('keywords')?>">
        <meta itemprop="image" name="image" content="<?=hnk_tpl('image')?>">

        <!-- Google -->
        <meta name="google" content="notranslate" />
        <meta name="google-site-verification" content="..." />

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable = no">

        <link rel="apple-touch-startup-image" href="<?=hnk_tpl_comp('path.favicon')?>/chargement.png" />
        <!-- Favicons -->
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?=hnk_tpl_comp('path.favicon')?>/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="<?=hnk_tpl_comp('path.favicon')?>/favicon.ico" />
        <!-- iOS device -->
        <link rel="apple-touch-icon" href="<?=hnk_tpl_comp('path.favicon')?>/apple-touch-icon-precomposed.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?=hnk_tpl_comp('path.favicon')?>/apple-touch-icon-72x72-precomposed.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?=hnk_tpl_comp('path.favicon')?>/apple-touch-icon-114x114-precomposed.png" />

        <link rel="canonical" href="<?=URL?>">
        <!--Ressources Ress-->
        <?=hnk_tpl_comp('styles')?>
        <?=hnk_tpl('style')?>

        <!--Ressources Locale-->

        <?=hnk_tpl_comp('scripts.top')?>

    </head>
    <body onload="hnk_init()" class="preload">

        <?=hnk_tpl('contents')?>

        <?=hnk_tpl_comp('scripts.bottom')?>
    </body>
</html>