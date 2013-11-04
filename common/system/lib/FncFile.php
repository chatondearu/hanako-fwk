<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/**
 * @name getLine_file()
 * @description
 *
 * @param $filename
 * @param int $line
 * @return string
 */
function getLine_file($filename,$line = 0){
    $f = file($filename);
    return rtrim($f[$line]);
}
function get_file($filename){
    return file($filename);
}
function get_strFile($filename){
    $f = get_file($filename);
    $lines=';';
    foreach ($f as $content) {
        $lines .= $content;
    }
    return $lines;
}

/**
 * @name getPointer_line()
 * @description
 *
 * @param $filename
 * @param int $nbLine
 * @return int
 */
function getPointer_line($filename,$nbLine = 0){
    if(!$file = fopen($filename,"r"))
        die;
    $i=0;
    $pointer = 0;
    while( ! feof($file))
    {
        $line = fgets($file);
        $pointer += strlen($line);
        $i++;
        if($i>$nbLine)break;
    }
    fclose($file);
    return $pointer;
}

/**
 * @name fwrite_stream()
 * @description
 *
 * @param $fp
 * @param $string
 * @return int
 */
function fwrite_stream($fp, $string) {
    for ($written = 0; $written < strlen($string); $written += $fwrite) {
        $fwrite = fwrite($fp, substr($string, $written));
        if ($fwrite === false) {
            return $fwrite;
        }
    }
    return $written;
}

/**
 * @name replace_file_lines()
 * @description
 *
 * @param $filename
 * @param $new_lines
 * @param null $source_file
 * @return string
 */
function replace_file_lines($filename, $new_lines, $source_file = NULL) {
    //characters
    //get lines into an array
    if ($source_file) {
        $lines = file($source_file);
    }
    else {
        $lines = file($filename);
    }
    //change the lines (array starts from 0 - so minus 1 to get correct line)
    foreach ($new_lines as $key => $value) {
        $lines[$key] = $value."\n";
    }
    //implode the array into one string and write into that file
    $new_content = implode('', $lines);

    return $new_content;
}

/**
 * @name write_file()
 * @description
 *
 * @param $filename
 * @param $str
 * @param int $context
 * @param bool $line
 * @return array
 */
function write_file($filename,$str,$context=1,$line=false){

    $tabs = array(
        'message'=>"Le Fichier ($filename) ne peut être ouvert en écriture",
        'statut'=>false
    );

    // Assurons nous que le fichier est accessible en écriture
    if (is_writable($filename)) {

        trim($str);
        if($context && $line === false){$str .= "\n";}

        // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
        // Le pointeur de fichier est placé à la fin du fichier
        // c'est là que $str sera placé
        if(is_numeric($line) && $line !== false){
            $str = replace_file_lines($filename,array($line=>$str));
            if (!$handle = fopen($filename, 'w+b')) {
                $tabs['message'] = "Impossible d'ouvrir le fichier ($filename)";
                return $tabs;
            }
        }elseif (!$handle = fopen($filename, 'a+b')) {
            $tabs['message'] = "Impossible d'ouvrir le fichier ($filename)";
            return $tabs;
        }

        // Ecrivons quelque chose dans notre fichier.
        if (fwrite_stream($handle, $str) === FALSE) {
            $tabs['message'] = "Impossible d'écrire dans le fichier ($filename)";
            return $tabs;
        }

        $tabs['message']="L'écriture de ($str) dans le fichier ($filename) a réussi";
        $tabs['statut']=true;

        fclose($handle);
    }
    return $tabs;
}

/**
 * @name searchStr_line()
 * @description
 *
 * @param $filename
 * @param $str
 */
function searchStr_line($filename,$str){

}