<!DOCTYPE html><html><head>    <title>Hanako fwk</title>    <base href="<?php echo URI; ?>" target="_self"/>    <META http-equiv="Content-Type" Content="text/html; charset=UTF-8">    <!-- TODO améliorer le systeme de récupération des ressources pour chaques pages -->    <link href="<?php echo CSS_SKINS_PATH; ?>global.css" rel="stylesheet" media="screen"/>    <link rel="icon" type="image/png" href="<?php echo IMG_SKINS_PATH; ?>favicon.ico" />    <script type="text/javascript">        //GLOBAL JAVASCRIPT        var URI = "<?php echo URI; ?>";        var LIB_JS_PATH = "<?php echo LIB_JS_PATH; ?>";    </script>    <!-- Jquery Framework-->    <script src="<?php echo LIB_JS_PATH.JQUERY ?>"></script>    <script src="<?php echo JS_PATH.PAGE ?>.js"></script></head><body onload="init()">