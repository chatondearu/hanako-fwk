<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

$&GeneratedTime;

function getGeneratedTime($type){
    global $GeneratedTime;
    if(is_string($type) && !($type != 'stop' && $type != 'start') ){
        switch($type){
            case 'start':
            //Get current time
                $mtime = microtime();
            //Split seconds and microseconds
                $mtime = explode(" ",$mtime);
            //Create one value for start time
                $mtime = $mtime[1] + $mtime[0];
            //Write start time into a variable
                $GeneratedTime['start'] = $mtime;
            break;
            case 'stop':
            //Get current time as we did at start
                $mtime = microtime();
                $mtime = explode(" ",$mtime);
                $mtime = $mtime[1] + $mtime[0];
            //Store end time in a variable
                $GeneratedTime['stop']  = $mtime;
            //Calculate the difference
               return ($GeneratedTime['stop'] - $GeneratedTime['start']);
            break;
        }
    }else return false;
}