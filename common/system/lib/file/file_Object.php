<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class file_Object {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    public $filename;
    private $p;

    private $f = null;

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name file_Object::__construct()
     * @return void
     **/
    public function __construct($filename = "text.txt", $point = 0) {
        if(file_exists($filename)){
            $this->filename = $filename;
            $this->f=file($filename);
            $this->p = $point;
        }else{
            throw new Exception('Le fichier \'existe pas');
        }
    }

    public function getTime(){
        return filemtime($this->filename);
    }

    public function _get_file(){
        return $this->f;
    }
    public function _set_file($file){
        $this->f=$file;
    }
    public function clone_file(){
        //TODO
    }

    public function toString(){
        $lines='';
        foreach ($this->f as $content) {
            $lines .= $content;
        }
        return $lines;
    }

    /**
     *   select
     **/
    public function select($where){
        if(is_numeric($where))
            return array($where,rtrim($this->f[$where]));
        elseif($where != ''){
            foreach($this->f as $key=>$line){
                if(strpos($line, $where)!==false)
                    return array($key,$line);
            }
        } return false;
    }


    /**
     *   insert
     **/
    public function insert($str,$context=1,$line=false){
        $tabs = array(
            'message'=>"Le Fichier ($this->filename) ne peut être ouvert en écriture",
            'statut'=>false
        );

        if (is_writable($this->filename)) {
            trim($str);
            if($context == 1){$str .= "\n";}

            if(is_numeric($line)){
                $str = $this::replace_lines($this->filename,array($line=>$str));
                if (!$handle = fopen($this->filename, 'w+b')) {
                    $tabs['message'] = "Impossible d'ouvrir le fichier ($this->filename)";
                    return $tabs;
                }
            }elseif (!$handle = fopen($this->filename, 'a+b')) {
                $tabs['message'] = "Impossible d'ouvrir le fichier ($this->filename)";
                return $tabs;
            }

            if ($this::fwrite_stream($handle, $str) === FALSE) {
                $tabs['message'] = "Impossible d'écrire dans le fichier ($this->filename)";
                return $tabs;
            }

            $tabs['message']="L'écriture de ($str) dans le fichier ($this->filename) a réussi";
            $tabs['statut']=true;

            fclose($handle);

            $this->_update();
        }
        return $tabs;
    }

    /**
     *   update
     **/
    public function update($line,$str){
        $this->insert($str,0,$line);
    }

    /**
     *   delete
     **/
    public function delete($line){

    }

    private function _update(){
        $this->f=file($this->filename);
    }

    static function fwrite_stream($fp, $str){
        for ($written = 0; $written < strlen($str); $written += $fwrite) {
            $fwrite = fwrite($fp, substr($str, $written));
            if ($fwrite === false) {
                return $fwrite;
            }
        }
        return $written;
    }

    static function replace_lines($filename, $new_lines, $source_file = NULL) {
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
            $lines[$key] = trim($value)."\n";
        }
        //implode the array into one string and return content
        $new_content = implode('', $lines);

        return $new_content;
    }

    static function get_pointer($filename,$nbLine = 0){
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
     *   Destructor
     *
     * <p> Destroy instance of class </p>
     *
     * @name file_Object::__destruct()
     * @return void
     **/
    public function __destruct() {

    }
}
