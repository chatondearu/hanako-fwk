<?php

/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name _connection
 * @author Romain Lienard <rlienard@keyneosoft.fr>
 * @http://keyneosoft.com
 * @copyright Romain Lienard Keyneosoft 2011
 * @version 0.0.0
 * @package _connection
 * @date: 09/05/12
 * @time: 14:14
 *
 **/
 
class connection_Core {


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
    * @var (String)
    * @desc ;
    */
    public $template;
    
    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name _connection::__construct()
     * @return void
     **/
    public function __construct() {
    //*** Connection Session Gesture ***//

        if( !isset($_SESSION['connected'])
            || $_SESSION['connected'] == false )
        {//i'm disconnected

            //set connection
            define('__CONNECTED',false);

            if( isset($_POST['mod_connection_connection'])
                && isset($_POST['mod_connection_login']) && $_POST['mod_connection_login'] != ''
                && isset($_POST['mod_connection_password']) && $_POST['mod_connection_password'] != ''){
                //We have connection request
                $this->setConnection($_POST['mod_connection_login'],$_POST['mod_connection_password']);
            }else{
            //No request to connection so to show form

                //connection form construction
                $form = $this->getTemplate();
                //show form
                define("__CONNECT_FORM",$form);
            }
        }
        else
        {// i'm connected
            $this->setEnv();
        }

    //*** end Connection ***//
    }

    protected function setEnv(){
        define('__CONNECTED',true);
        $user = new soft_Users();
        $user->set($_SESSION['user']);
        if(__CONNECT_IFTYPE)
            define('__TYPE_USER',$user->getType()->get('constant_types_users'));
    }

    protected function setConnection($login,$mdp){
        //prepare user class
        $user = new soft_Users();
        //check if user login and pass exist and hashing password
        if(__CONNECT_CRYPT_METHOD != '')
            $mdp = md5(hash(__CONNECT_CRYPT_METHOD,$mdp));
        if($user->ifLoginExist($login,$mdp)){
            //set session
            $_SESSION['connected'] = true;
            $_SESSION['user'] = $user->get();
            if(__CONNECT_IFTYPE){
                $type_user = $user->getType();
                $_SESSION['user_type'] = $type_user->get('constant_types_users');
            }
            header('Location: '.__CONNECT_RETURN_LOCATION);
        }
    }

    protected function getTemplate(){
        $temp = file(MODULES_PATH.'connection/form.temp');
        $this->template = $temp;
        $parseTemp = '';
        foreach($temp as $line){
            $parseTemp .= $line."\n";
        }
        return $parseTemp;
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
