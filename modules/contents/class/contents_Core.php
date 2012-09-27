<?php

class contents_Core {

    /*~*~*~*~*~*~*~*~*~*~*/
	/*  1. proprieties   */
	/*~*~*~*~*~*~*~*~*~*~*/

    public $language = null;
    public $page_content = array();
    private $themes = array();

    /*~*~*~*~*~*~*~*~*~*~*/
	/*  2.methods        */
	/*~*~*~*~*~*~*~*~*~*~*/

	/**
	 *   Constructor
	 *
	 * <p> Construct instance of class </p>
	 *
	 * @name module_Contents_core::__construct()
	 * @return void
	 **/
	public function __construct($themes) {
        $this->language = new contents_Language();
        $this->themes = $themes;
	}

    private function getAllFromDatabase(){
        global $db;
        //TODO à faire après modification du core database
    }

    private function getAllFromTxtFile(){
        //TODO rajouter la gestion de skins (attente module de skins)
        $pathFile = $this->getFileName();
        if(file_exists($pathFile))
            $temp = file($pathFile);
        else{//TODO generer une erreur
            return false;
        }
        foreach($temp as $line){
            if(trim($line) != null && trim($line) != ''){
                $value = preg_split('/=/',$line,2);
                $this->page_content[$value[0]] = preg_replace('/\r\n/','',$value[1]);
            }
        }

        return true;
    }

    private function getFileName(){
        if(USE_SKIN)
            if(SKIN !== 'default')
                return PAGES_PATH.'contents/'.PAGE.'_'.$this->language->get().'_'.SKIN.'.txt';
            else
                return PAGES_PATH.'contents/'.PAGE.'_'.$this->language->get().'.txt';
        else
            return PAGES_PATH.'contents/'.PAGE.'_'.$this->language->get().'.txt';
    }

    private function setThemes($txt){
        foreach($this->themes as $key=>$val){
            $txt = str_replace($key,$val,$txt);
        }
        return $txt;
    }

    public function get($label = false){
        $this->getAllFromTxtFile();
        if($label)
            if(USE_TEMPLATE)
                return $this->setThemes($this->page_content[$label]);
            else
                return $this->page_content[$label];
        else
            return $this->page_content;
    }



    /**
    *   Destructor
    *
    * <p> Destroy instance of class </p>
    *
    * @name _connection::__destruct()
    * @return void
    **/
    public function __destruct() {
		unset($this);
    }
}

?>