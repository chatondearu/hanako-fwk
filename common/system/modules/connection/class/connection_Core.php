<?php

/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name _connection
 * @author Romain Lienard <me@rlienard.fr>
 * @http://rlienard.fr
 * @copyright Romain Lienard 2011
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

    /**
     * @var (String)
     * @desc ;
     */
    public $error = false;

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name connection_Core::__construct()
     * @return void
     **/
    public function __construct() {
        global $form;
        //*** Connection Session Gesture ***//

        if( !isset($_SESSION['connected'])
            || $_SESSION['connected'] == false )
        {//i'm disconnected

            //set connection
            define('__CONNECTED',false);

            if( isset($_POST['mod_connection_connection'])){

                if(isset($form)){
                    $form->rule("mod_connection_username","Pseudo","alphanum",true,25,2);
                    $form->rule("mod_connection_password","Mot de passe","password",true,20,6);
                    if($form->start()){
                        //We have connection request
                        $this->setConnection($_POST['mod_connection_username'],$_POST['mod_connection_password']);
                    }else{
                        $this->error = 'no_exist';
                    }
                }elseif( isset($_POST['mod_connection_connection'])
                    && isset($_POST['mod_connection_username']) && $_POST['mod_connection_username'] != ''
                    && isset($_POST['mod_connection_password']) && $_POST['mod_connection_password'] != '')
                    //We have connection request
                    $this->setConnection($_POST['mod_connection_username'],$_POST['mod_connection_password']);

            }//No request to connection so to show form


            //connection form construction
            //show form
            define("__CONNECT_FORM",$this->getTemplate());
            define("__CONNECT_FORM_JS",$this->getTemplate(true));
        }
        else
        {// i'm connected
            $this->setEnv();
        }

        //*** end Connection ***//
    }

    protected function setEnv(){
        define('__CONNECTED',true);
        $userId = $_SESSION['user'];
        $user = new Users();
        $user->retrieve($userId);
        if(__CONNECT_IFTYPE)
            define('__TYPE_USER',$user->getType()->get('constant'));
    }

    protected function setConnection($username,$mdp){

        $username = $this->secureString($username);
        $mdp = $this->secureString($mdp);

        //prepare user class
        $user = new Users();
        //check if user username and pass exist and hashing password
        if(__CONNECT_CRYPT_METHOD != '')
            $mdp = md5(hash(__CONNECT_CRYPT_METHOD,$mdp));
        if($user->ifUserExist($username,$mdp)){
            //set session
            $_SESSION['connected'] = true;
            $_SESSION['user'] = $user->get('id');
            $_SESSION['username'] = $user->get('username');
            if(__CONNECT_IFTYPE){
                $type_user = $user->getType();
                $_SESSION['user_type'] = $type_user->get('constant');
            }
            header_redirect(HANAKO_BASEROOT);
        }else{
            $this->error = 'no_exist';
        }
    }

    protected function secureString($str){
        //if($str)
        return trim($str);
    }

    protected function getTemplate($toJS=false){
        if(!function_exists('transformToJS')){
            function transformToJS($str){
                $str = str_replace('"','\\"',trim($str));
                $str .= "';";
                $str = "__CONNECT_FORM += '".$str;
                return $str;
            }
        }
        $temp = file(HANAKO_MODULES.'/connection/form.temp');
        $this->template = $temp;

        $parseTemp ='';
        foreach($temp as $line){
            $parseTemp .=($toJS)?transformToJS($line):$line."\n";
        }
        return $parseTemp;
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
