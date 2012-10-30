<?php

class contents_Language {

    /*~*~*~*~*~*~*~*~*~*~*/
	/*  1. proprieties   */
	/*~*~*~*~*~*~*~*~*~*~*/

    protected $isInit = false;
    protected $initLang = null;

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
	public function __construct() {
        $this->initLanguage();
	}

    /**
	 *   initLanguage
	 *
	 * <p> Initialise language </p>
	 *
	 * @name module_Contents_core::__construct()
	 * @return void
	 **/
    public function initLanguage($lang = null){
        if(!is_null($lang))
            $_SESSION['mod_language'] = $lang;
        elseif(!isset($_SESSION['mod_language']))
            $_SESSION['mod_language'] = DEFAULT_LANGUAGE;

        $this->initLang = $_SESSION['mod_language'];
        define('__LANGUAGE',$this->initLang);

        if(!$this->isInit)
            $this->isInit = true;
        return true;
    }


    /**
	 *   get
	 *
	 * <p> get language label  </p>
	 *
	 * @name module_Contents_core::get()
	 * @return void
	 **/
    public function get(){
        return $this->initLang;
    }

    /**
	 *   set
	 *
	 * <p>  set language label  </p>
	 *
	 * @name module_Contents_core::set()
	 * @return void
	 **/
    public function set($lang){
        $this->initLanguage($lang);
        return true;
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