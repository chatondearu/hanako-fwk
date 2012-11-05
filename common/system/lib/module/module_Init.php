<?php

/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name module_init
 * @author Romain Lienard <rlienard@keyneosoft.fr>
 * @http://keyneosoft.com
 * @copyright Romain Lienard Keyneosoft 2011
 * @version 0.0.0
 * @package module_init
 * @date: 09/05/12
 * @time: 11:56
 *
 **/
 
class module_Init {


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
    * @var (String)
    * @desc ;
    */
    protected $modActivated = array();
    
    
    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name module_init::__construct()
     **/
    public function __construct() {

    }

    /**
     *   require_mod
     *  <p> initialise et met en place le module demandé en parametre <p>
     *
     * @name module_init::require_mod()
     * @param  $name
     * @return void
     */
    public function require_mod($name){
        require_once(MODULES_PATH.$name.'/init_mod_'.$name.'.php');
        eval('$this->modActivated[$name]= $mod_'.$name.';');
    }

    /**
     *   require_mod
     *  <p> renvois le core d'un module <p>
     *
     * @name module_init::get()
     * @param  $name
     * @return Object
     */
    public function get($name = null){
        if(array_key_exists($name,$this->modActivated))
            return $this->modActivated[$name];
        else{
            if(DEBUG)echo 'Aucun module "'.$name.'" trouvé';
            return false;
        }
    }

    /**
    *   Destructor
    *
    * <p> Destroy instance of class </p>
    *
    * @name module_init::__destruct()
    * @return void
    **/
    public function __destruct() {
        
    }
}
