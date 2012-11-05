<!DOCTYPE html>
<html>
    <head>

        <title>{{{title}}}</title>
        <base href="<?=URL; ?>" target="_self"/>
        <META http-equiv="Content-Type" Content="text/html; charset={{{charset}}}">

        <meta itemprop="name" content="{{{page.Name}}}">
        <meta itemprop="description" content="{{{page.Description}}}">

        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes">
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable = no">

        <!-- Favicons -->
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?=IMG_SKINS_PATH; ?>/favicon/favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="<?=IMG_SKINS_PATH; ?>/favicon/favicon.ico" />
        <!-- iOS device -->
        <link rel="apple-touch-icon" href="<?=IMG_SKINS_PATH; ?>/favicon/apple-touch-icon-precomposed.png" />
        <link rel="apple-touch-icon" sizes="72x72" href="<?=IMG_SKINS_PATH; ?>/favicon/apple-touch-icon-72x72-precomposed.png" />
        <link rel="apple-touch-icon" sizes="114x114" href="<?=IMG_SKINS_PATH; ?>/favicon/apple-touch-icon-114x114-precomposed.png" />

        <!--Ressources Ress-->
        <link href="<?=CSS_SKINS_PATH; ?>global.css" rel="stylesheet" media="screen"/>
        {{{style}}}

        <!--Ressources Locale-->

        <script type="text/javascript">
            //GLOBAL JAVASCRIPT
            var URI = "<?=URI; ?>";
            var LIB_JS_PATH = "<?=LIB_JS_PATH; ?>";
        </script>

        <!-- Jquery Framework-->
        {{{scriptTop}}}
        <script src="<?=LIB_JS_PATH.JQUERY ?>"></script>
        <script src="<?=JS_PATH.PAGE ?>.js"></script>

    </head>
    <body onload="init()">

        {{{scriptBottom}}}
    </body>

</html>