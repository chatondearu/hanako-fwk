<?php

/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name soft_users
 * @author Romain Lienard <rlienard@keyneosoft.fr>
 * @http://keyneosoft.com
 * @copyright Romain Lienard Keyneosoft 2011
 * @version 0.0.0
 * @package soft_users
 * @date: 18/04/12
 * @time: 11:42
 *
 **/
 
class soft_Users extends database_Member {


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
    * @var (String)
    * @desc ;
    */
    protected $id_users;	//int(11)	Non
    protected $types_id_users;	//int(11)	Non
    protected $name_users;	//varchar(50)	Non
    protected $firstname_users;	//varchar(50)	Oui	NULL
    protected $mail_users;	//varchar(250)	Non
    protected $login_users;	//varchar(25)	Non
    protected $password_users;	//varchar(250)	Non
    protected $phone1_users;	//varchar(10)	Non
    protected $phone2_users;	//varchar(10)	Oui	NULL
    protected $last_connection_users;	//timestamp	Non	CURRENT_TIMESTAMP

    private $type_user = null;

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name soft_users::__construct()
     * @return void
     **/
    public function __construct($id=null) {
        $this->primaryKey = "id_users";
        $this->tableName = "soft_users";
        if(!is_null($id)){
            $this->getDbLine($id);
            $this->type_user = new soft_types_users($this->types_id_users);
        }
    }

    public function getType(){
        if(is_null($this->type_user))
        $this->type_user = new soft_Types_users($this->types_id_users);
        return $this->type_user;
    }

    public function ifLoginExist($login,$password){
        global $db;
        try{

            $result = $db->select("SELECT *
                        FROM  `soft_users`
                        WHERE  `login_users` =  '".$login."'
                        AND  `password_users` =  '".$password."'",1);
            if(sizeof($result) > 0){

                $this->set($result);
                $this->type_user = new soft_Types_users($this->types_id_users);

                $this->last_connection_users = $db->formatTimestamp(time());
                $this->update();

            }
            return sizeof($result) > 0;

        }catch(exception $e){
            return false;
        }
    }

    /**
    *   Destructor
    *
    * <p> Destroy instance of class </p>
    *
    * @name soft_users::__destruct()
    * @return void
    **/
    public function __destruct() {
        
    }
}
