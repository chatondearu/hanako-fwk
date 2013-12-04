<?php


/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name form_Core
 * @author Romain Lienard <rlienard@web-softcity.com>
 * @http://web-softcity.com
 * @copyright Romain Lienard
 * @version 0.0.1
 * @package form_Core
 * @date: 3/11/13
 * @time: 03:21
 *
 **/

class form_Core {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    const CHARS_ENCODE = "UTF-8";

    public $msg = false;
    public $isCheck = true;
    //return values
    public $values = array();
    public $dataWay = null;
    public $method = 'POST'; //values: POST|DELETE|PUT|GET

    private $rules = array();

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name form_Core::__construct()
     * @param $lib (integer)
     * @return void
     **/
    public function __construct($method = 'POST', $dataWay = null){
        $this->method = $method;
        $this->dataWay = $dataWay;
    }

    public function rule(
        $name,
        $label = null,
        $lib = null,
        $isRequired = null,
        $maxLength = null,
        $minLength = null,
        $min = null,
        $max = null,
        $format = null
    ){
        $this->rules[$name] = new form_Rules(
            $label,
            $lib,//type de champ
            $isRequired,
            $maxLength,
            $minLength,
            $min,
            $max,
            $format
        );
    }

    public function start(){
        if($this->dataWay == null){

            if($this->method == "GET"){
                $arr = $_GET;
            } elseif ($this->method == "POST") {
                $arr = $_POST;
            } else return $this->isCheck;

            foreach ($this->rules as $key => $rule) {

                if(isset($arr[$key]) && $arr[$key] != ''){
                    if($this->rules[$key]->validate($arr[$key])){
                        $this->values[$key] = $this->rules[$key]->save_result;
                    }else{
                        $this->isCheck = false;
                    }
                }elseif($this->rules[$key]->required()){
                    //tout les champs obligatoire ne sont pas remplis j'affiche le message correspondant
                    $this->msg = "Tout les champs obligatoires n'ont pas été remplis<br/>";
                    $this->isCheck = false;
                }

            }

        } else {

            if(is_array($this->dataWay)){
                foreach ($this->rules as $key => $rule) {

                    if(isset($this->dataWay[$key]) && $this->dataWay[$key] != ''){

                        if($this->rules[$key]->validate($this->dataWay[$key])){
                            $this->values[$key] = $this->rules[$key]->save_result;
                        }else{
                            $this->isCheck = false;
                        }
                    }elseif($this->rules[$key]->required()){
                        //tout les champs obligatoire ne sont pas remplis j'affiche le message correspondant
                        $this->msg = "Tout les champs obligatoires n'ont pas été remplis<br/>";
                        $this->isCheck = false;
                    }

                }
            } elseif (is_object($this->dataWay)) {
                foreach ($this->rules as $key => $rule) {

                    if(isset($this->dataWay->{$key}) && $this->dataWay->{$key} != ''){

                        if($this->rules[$key]->validate($this->dataWay->{$key})){
                            $this->values[$key] = $this->rules[$key]->save_result;
                        }else{
                            $this->isCheck = false;
                        }
                    }elseif($this->rules[$key]->required()){
                        //tout les champs obligatoire ne sont pas remplis j'affiche le message correspondant
                        $this->msg = "Tout les champs obligatoires n'ont pas été remplis<br/>";
                        $this->isCheck = false;
                    }

                }
            }

        }
        return $this->isCheck;
    }

    public function get_rule($name){
        if(isset($this->rules[$name]))
            return $this->rules[$name];
    }
    public function get_error($name,$prefix=null,$suffix=null){
        if(isset($this->rules[$name]))
        return ($this->rules[$name]->save_error)?$prefix.$this->rules[$name]->save_error.$suffix:false;
    }
    public function errors(){
        $tmp = array();
        foreach($this->rules as $name=>$rule){
            $tmp[$name] = $rule->save_error;
        }
        return $tmp;
    }

    public function set_error($name,$value){
        if(isset($this->rules[$name])){
            $this->rules[$name]->save_error = $value;
            $this->isCheck = $value==null;
        }
    }

    public function value($name,$prefix=null,$suffix=null){
        if(isset($this->values[$name]))
        return ($this->values[$name])?$prefix.$this->values[$name].$suffix:false;
    }

    /**
     *   Destructor
     *
     * <p> Destroy instance of class </p>
     *
     * @name form_Core::__destruct()
     * @return void
     **/
    public function __destruct() {
        unset ($this);
    }

}


//Tableau correspondant à chaque champs du formulaire pour la validation
/*
$inputs = array(
    "nom"           => array("data" => new coreData("Nom","simpleText",true,25,2),"result" => null ),
    "prenom"        => array("data" => new coreData("Prénom","simpleText",true,25,2), "result" => null ),
    "genre"         => array("data" => new coreData("Genre","text",false,25,2), "result" => null ),
    "age"           => array("data" => new coreData("Age","integer",true,2,2,18,99), "result" => null ),
    "dateNaissance" => array("data" => new coreData("Date de naissance","birthday",false,null,null,10,105,"dd/mm/yyyy"), "result" => null ),
    "mail"          => array("data" => new coreData("e-mail","mail",true,250,5), "result" => null ),
    "tel"           => array("data" => new coreData("Téléphone","numeric",false,10,10), "result" => null ),
    "adresse"       => array("data" => new coreData("Adresse","text",false,250,2), "result" => null ),
    "cp"            => array("data" => new coreData("Code Postal","numeric",false,5,5), "result" => null ),
    "ville"         => array("data" => new coreData("Ville","text",false,25,2), "result" => null ),
    "cgv"           => array("data" => new coreData("Conditions","accept",true), "result" => null ),
    "titre"         => array("data" => new coreData("Titre","text",false,150,3), "result" => null ),
    "message"       => array("data" => new coreData("Message","text",false,500,3), "result" => null ),
    "mdp"           => array("data" => new coreData("Mot de passe","password",true,8,6), "result" => null )
);
*/