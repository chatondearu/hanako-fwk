<?php

        ini_set('display_errors', 1);
        ini_set('error_reporting', 2047);

    if(isset($_GET['page']) && $_GET['page'] != '' ){

        define('PAGE',$_GET['page']);
        include_once('include/prepend.php');

        ini_set('include_path','.:'.SERVER_PATH);

        include(VIEWS_PATH.PAGE.'.php');

        include('include/append.php');
    }if(isset($_GET['service']) && $_GET['service'] != '' ){

        define('SERVICE',$_GET['service']);
        define('PAGE',false);
        include_once('include/prepend.php');

        ini_set('include_path','.:'.SERVER_PATH);

        include(SERVICES_PATH.SERVICE.'.php');

        include('include/append.php');
    }

?>