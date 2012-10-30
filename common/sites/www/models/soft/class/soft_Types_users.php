<?php

/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name soft_types_users
 * @author Romain Lienard <rlienard@keyneosoft.fr>
 * @http://keyneosoft.com
 * @copyright Romain Lienard Keyneosoft 2011
 * @version 0.0.0
 * @package soft_types_users
 * @date: 23/04/12
 * @time: 10:49
 *
 **/
 
class soft_Types_users extends database_Member{


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
    * @var (String)
    * @desc ;
    */
    protected $id_types_users;
    protected $libelle_types_users;
    protected $constant_types_users;
    
    
    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name soft_types_users::__construct()
     * @return void
     **/
    public function __construct($id=null) {
        $this->primaryKey = "id_types_users";
        $this->tableName = "soft_types_users";
        if(!is_null($id)){
            $this->getDbLine($id);
        }
    }

    /**
    *   Destructor
    *
    * <p> Destroy instance of class </p>
    *
    * @name soft_types_users::__destruct()
    * @return void
    **/
    public function __destruct() {
        
    }
}
