<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

function urlValid($url){

    // SCHEME
    $urlregex = "^(https?|ftp)\:\/\/";

    // USER AND PASS (optional)
    $urlregex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";

    // HOSTNAME OR IP
    $urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*"; // http://x = allowed (ex. http://localhost, http://routerlogin)
    //$urlregex .= "[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)+"; // http://x.x = minimum
    //$urlregex .= "([a-z0-9+\$_-]+\.)*[a-z0-9+\$_-]{2,3}"; // http://x.xx(x) = minimum
    //use only one of the above

    // PORT (optional)
    $urlregex .= "(\:[0-9]{2,5})?";
    // PATH (optional)
    $urlregex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
    // GET Query (optional)
    $urlregex .= "(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?";
    // ANCHOR (optional)
    $urlregex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?\$";

    // check
    return eregi($urlregex, $url);

}

function urlExist($url){

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_NOBODY, true);
    $result = curl_exec($curl);

    if ($result !== false)
    {
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($statusCode == 404)
            return false;
        else
            return true;
    }
    else return false;

}

//@return Array() with
// "statut" : 0 si KO, 1 si redirect ou bien pour faire passer en local, 2 si OK
// "code" : code HTTP
// "message" : message
function urlConnect($host,$path)
{
    $tab_return["statut"] = 1;
    $tab_return["code"] = 0;
    $tab_return["message"] = "Pas de test de connexion\n";

    $connect = 0;
    $no_code = 0;
    //connexion par socket
    if ($fp = @fsockopen($host,80))
    {
        //traitement du path
        if(substr($path,strlen($path)-1) != '/')
        {
            if(!ereg("\.",$path))
                $path .= "/";
        }
        //envoi de la requete HTTP
        fputs($fp,"GET ".$path." HTTP/1.1\r\n");
        fputs($fp,"Host: ".$host."\r\n");
        fputs($fp,"Connection: close\r\n\r\n");
        //on lit le fichier
        $line = fread($fp,255);
        $en_tete = $line;
        //on lit tant qu'on n'est pas la fin du fichier ou
        // qu'on trouve le debut du code html...
        while (!feof($fp) && !ereg("<",$line) )
        {
            $en_tete .= $line;
            $line = fread($fp,255);
        }
        fclose($fp);
        //on switch sur le code HTTP renvoye
        $no_code = substr($en_tete,9,3);
        switch ($no_code)
        {
            // 2** la page a été trouvée
            case 200 :    $message = "OK";
                $color = "#33cc00";
                $connect = 2;
                break;
            case 204 :    $message = "Cette page ne contient rien! (204)";
                $color = "#ff9966";
                break;
            case 206 :    $message = "Contenu partiel de la page! (206)";
                $color = "#ff9966";
                break;
            // 3** il y a une redirection
            case 301 : $message = "La page a été déplacéé définitivement!(301)";
                $message .= seek_redirect_location($en_tete);
                $color = "#ff9966";
                $connect = 1;
                break;
            case 302 :  $message = "La page a été déplacéé momentanément!(302)";
                $message .= seek_redirect_location($en_tete);
                $color = "#ff9966";
                $connect = 1;
                break;
            // 4** erreur du coté du client
            case 400 :    $message = "Erreur dans la requête HTTP! (400)";
                $color = "#ff0000";
                break;
            case 401 :    $message = "Authentification requise! (401)";
                $color = "#ff0000";
                break;
            case 402 :    $message = "L'accès à la page est payant! (402)";
                $color = "#ff0000";
                break;
            case 403 :    $message = "Accès à la page refusé! (403)";
                $color = "#ff0000";
                break;
            case 404 :    $message = "Page inexistante! (404)";
                $color = "#ff0000";
                break;
            // 5** erreur du coté du serveur
            case 500 :    $message = "Erreur interne au serveur! (500)";
                $color = "#ff0000";
                $connect = 1;
                break;
            case 502 :  $message = "Erreur cause passerelle du serveur! (502)";
                $color = "#ff0000";
                break;
            // cas restant
            default : $message = "Erreur non traitée -> numéro est : $no_code!";
            $color = "#000000";
            break;
        }
    }
    else
    {
        $message = "Impossible de se connecter par socket";
        $color = "#ff0000";
    }
    //creation du tableau avec les valeurs a rendre
    $data_return["statut"] = $connect; //la page est OK ou KO (200 => OK sinon KO)
    $data_return["code"] = $no_code; //code HTTP renvoye
    $data_return["message"] = "<font color=\"".$color."\">".$message."</font>\n";
    return $data_return;
}