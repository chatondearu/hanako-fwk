<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Header {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     * @var (Array)
     * @desc NC;
     */
    protected $headers = array();

    /**
     * @var (Array)
     * @desc NC;
     */
    private $is_redirected = false;


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name hnk_Template::__construct()
     **/
    public function __construct(){}

    public function set($values) {
        if (is_array($values)) {
            foreach ($values as $key => $val) {
                $this->headers[$key] = $val;
            }
        } else {
            array_push($this->headers, $values);
        }
    }

    public function redirect($location, $Bln_Replace = 1, $Int_HRC = NULL) {

        if($this->is_redirected) return false;

        $this->is_redirected = true;
        if($location[0] != '/') $location = '/'.$location;

        if(!headers_sent())
        {
            header('location: ' . urldecode(URL.$location), $Bln_Replace, $Int_HRC);
            exit;
        }

        exit('<meta http-equiv="refresh" content="0; url=' . urldecode(URL.$location) . '"/>'); # | exit('<script>document.location.href=' . urldecode($Str_Location) . ';</script>');
        return;

    }

    public function exec() {
        if($this->is_redirected) return false;
        foreach($this->headers as $key=>$val){
            $str = (is_numeric($key))? $val : $key . ' : ' . $val ;
            $this->heading($str);
        } return true;
    }
    public function reset() {
        $this->headers = array();
    }

    private function heading($val) {
        header($val);
    }

    /**
     *   Destructor
     *
     * <p> Destroy instance of class </p>
     *
     * @name connection_Core::__destruct()
     * @return void
     **/
    public function __destruct() {
        unset($this);
    }
}
$hnk_headers = new Header();

function header_redirect($path) {
    global $hnk_headers;
    $hnk_headers->redirect($path);
}

function header_set($vals) {
    global $hnk_headers;
    $hnk_headers->set($vals);
}

function header_exec() {
    global $hnk_headers;
    $hnk_headers->exec();
}

function header_reset() {
    global $hnk_headers;
    $hnk_headers->reset();
}

function header_change($values) {
    header_reset();
    header_set($values);
    header_exec();
}