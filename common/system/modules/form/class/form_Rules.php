<?php

    /**
     *
     * détail
     *
     * <p>***</p>
     *
     * @name form_Rules
     * @author Romain Lienard <rlienard@web-softcity.com>
     * @http://web-softcity.com
     * @copyright Romain Lienard
     * @version 0.0.1
     * @package form_Rules
     * @date: 3/11/13
     * @time: 03:21
     *
     **/

class form_Rules {


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    const CHARS_ENCODE = "UTF-8";

    /**
    * @var (String)
    * @desc ;
    */
    public $type;

    /**
    * @var (String)
    * @desc ;
    */
    public $label;

    /**
    * @var (Integer)
    * @desc ;
    */
    public $maxLength;

    /**
    * @var (Integer)
    * @desc ;
    */
    public $minLenght;

    /**
    * @var (Numeric)
    * @desc ;
    */
    public $max;

    /**
    * @var (Numeric)
    * @desc ;
    */
    public $min;

    /**
     *@var (String)
     *@desc ;
     */
    public $format;

    /**
    * @var (Boolean)
    * @desc ;
    */
    public $required;

    /**
    * @var (Void)
    * @desc ;
    */
    public $save_result;

    /**
    * @var (Void)
    * @desc ;
    */
    public $save_error = false;

    private $tmpByTypes = array(
        "simpleText" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "alphanum" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "text" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "html" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "numeric" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "integer" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "boolean" => array(
                "required" => "",
                "validate" => "",
        ),
        "date" => array(
                "required" => "Votre",
                "validate" => "",
        ),
        "birthday" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "mail" => array(
                "required" => "Votre",
                "validate" => "Votre",
        ),
        "accept" => array(
                "required" => "Accepter nos",
                "validate" => "",
        ),
        "password" => array(
                "required" => "Un",
                "validate" => "Le",
        )
    );

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name form_Rules::__construct()
     * @param $lib (integer)
     * @return void
     **/
    public function __construct(
        $label = null,
        $type = null,
        $isRequired = null,
        $maxLength = null,
        $minLength = null,
        $min = null,
        $max = null,
        $format = null
    ) {
        //récupération des données relative à aux sécurité du champs et ces informations.
        $this->required =($isRequired != null)?  $isRequired : null ;
        $this->label = ($label != null)?$label : null ;
        $this->type = ($type != null)?$type : null ;
        $this->maxLength = ($maxLength != null)?$maxLength : null ;
        $this->minLength = ($minLength != null)?$minLength : null ;
        //for numeric or integer or birthday
        $this->min = ($min != null)?$min : null ;
        $this->max = ($max != null)? $max : null ;
        //for date
        $this->format = ($format != null)? $format : null ;
    }

    /**
     *   Verification des champs requis et retour String selon type
     *
     * <p>  </p>
     *
     * @name form_Rules::required()
     * @return string
     **/
    public function required(){

        $return=($this->required == true)? "champ obligatoire" : false;
        return $this->saveErrorMessage($return);

    }

    /**
     *   Validation selon type d'un retour formulaire et protections des résultats
     *
     * <p>  </p>
     *
     * @name form_Rules::validate()
     * @return boolean
     **/
    public function validate($val){
        $ifValid = $this->{'secure_'.$this->type}($val);
        return($ifValid)?$ifValid:false;
    }

    /**
     *   Sécurisation d'un type "simpleText"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_simpleText()
     * @return boolean
     **/
    public function secure_simpleText($val){

        $test = $this->secure_text($val);
        $this->save_result = null;

        $val = sprintf("%s",$val);
        $val = trim($val);
        $val = htmlentities($val, ENT_QUOTES , self::CHARS_ENCODE );

        if(!ctype_alpha($val)){
            $this->saveErrorMessage("l'utilisation de chiffres ou de caractères spéciaux est proscrite");
            return false;
        }elseif($test){
            $this->save_result = $val;
            return true;
        }else{
            return false;
        }
    }

    /**
     *   Sécurisation d'un type "alphanum"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_alphanum()
     * @return boolean
     **/
    public function secure_alphanum($val){

        $test = $this->secure_text($val);
        $this->save_result = null;

        $val = sprintf("%s",$val);
        $val = trim($val);
        $val = htmlentities($val, ENT_QUOTES , self::CHARS_ENCODE );

        if(!ctype_alnum($val)){
            $this->saveErrorMessage("l'utilisation de caractères spéciaux est proscrite");
            return false;
        }elseif($test){
            $this->save_result = $val;
            return true;
        }else{
            return false;
        }
    }

    /**
     *   Sécurisation d'un type "text"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_text()
     * @return boolean
     **/
    public function secure_text($val){
        $val = sprintf("%s",$val);
        $val = trim($val);
        $val = htmlentities($val, ENT_QUOTES , self::CHARS_ENCODE );
        if($this->ifNull($val))
            $this->saveErrorMessage("une valeur est attendue");
        else{
            $test = $this->inMaxMinLenght($val);
            if($test){
                $this->save_result = $val;
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     *   Sécurisation d'un type "html"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_html()
     * @return boolean
     **/
    public function secure_html($val){
        $val = sprintf("%s",$val);
        $val = trim($val);
        if($this->ifNull($val))
            $this->saveErrorMessage("une valeur est attendue");
        else{
            $test = $this->inMaxMinLenght($val);
            if($test){
                $this->save_result = $val;
                return true;
            }else{
                return false;
            }
        }
    }

    /**
     *   Sécurisation d'un type "number"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_number()
     * @return boolean
     **/
    public function secure_numeric($val){
        $test = $this->inMaxMinLenght($val);
        $test2 = $this->inMaxMin($val);
        $test3 = is_numeric($val);

        if($test && $test2 && $test3){
            $this->save_result = $val;
            return true;
        }else{
            if(!$test3){
                $this->saveErrorMessage("seul une valeur numérique est autorisé");
            }
            return false;
        }
    }

    /**
     *   Sécurisation d'un type "interger"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_integer()
     * @return boolean
     **/
    public function secure_integer($val){
        $val = sprintf("%d",$val);
        $val = abs($val);
        $val = intval($val);
        
        $test = $this->secure_numeric($val);
        if($test){
            $this->save_result = $val;
            return $test;
        }else{
            return $test;
        }
    }

    /**
     *   Sécurisation d'un type "boolean"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_boolean()
     * @return string
     **/
    public function secure_boolean($val){
        if($val){
            $this->save_result = true;
            return true;
        }else{
            $this->save_result = false;
            return false;
        }
    }

    /**
     *   Sécurisation d'un type "accept"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_accept()
     * @return string
     **/
    public function secure_accept($val){
        $test = $this->secure_boolean($val);
        if($test){ $this->save_result = $val; return true;} else return false;
    }

    /**
     *   Sécurisation d'un type "date"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_date()
     * @return string
     **/
    public function secure_date($val){

        $format = $this->format;
        $separator_only = str_replace(array('m','d','y'),'', $format);
        $separator = $separator_only[0];
        $regexp = str_replace($separator, "\\" . $separator, $format);
        $regexp = str_replace('mm', '(0?[1-9]|1[0-2])', $regexp);
        $regexp = str_replace('dd', '(0?[1-9]|[1-2][0-9]|3[0-1])', $regexp);
        $regexp = str_replace('yyyy', '(19|20)?[0-9][0-9]', $regexp);

        if(preg_match('/'.$regexp.'\z/', $val)){
            list($dd,$mm,$yy) = @explode('-', $this->newFormatDate($val,$separator,'d-m-Y'));
            if ($dd=="" && $mm=="" && $yy==""){
                $this->saveErrorMessage( "vérifier le format (".$this->format.")" );
                return false;
            }
            $stamp = strtotime( "$dd-$mm-$yy" );
            if (!is_numeric($stamp)){
                $this->saveErrorMessage( "vérifier le format (".$this->format.")" );
                return false;
            }
            $month = date( 'm', $stamp );
            $day   = date( 'd', $stamp );
            $year  = date( 'Y', $stamp );
            //echo $day.'/'.$month.'/'.$year;
            if (checkdate($month, $day, $year)){
                $this->save_result = $val;
                return true;
            }
            $this->saveErrorMessage("cette date ne peut exister.");
            return false;
        }
        $this->saveErrorMessage( "vérifier le format (".$this->format.")" );
        return false;
    }

    /**
     *   Sécurisation d'un type "birthday"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_birthday()
     * @return string
     **/
    public function secure_birthday($val){

        $format = $this->format;
        $separator_only = str_replace(array('m','d','y'),'', $format);
        $separator = $separator_only[0];

        $test = $this->secure_date($val);
        if($test){
            //calcul de l'age et vérification
            $now = time();
            list($dd,$mm,$yy) = @explode($separator,$this->newFormatDate($val,$separator,'d-m-Y'));
            $stamp = strtotime("$dd-$mm-$yy");
            $age = $now - $stamp;
            $age = $age/31536000;
            if($this->inMaxMin($age)){
                return true;
            }
            $this->saveErrorMessage(null);
            $this->saveErrorMessage( "Vous êtes concidéré comme trop jeune, vous devez avoir plus de ".$this->min." ans");
        }
        $this->save_result = null;
        return false;
    }

    /**
     *   Sécurisation d'un type "mail"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_mail()
     * @return string
     **/
    public function secure_mail($val){
        $test = $this->secure_text($val);
        if($test){
            if(preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $val)){
                return true;
            }else{
                $this->saveErrorMessage("le mail n'est pas valide ex:username@domaine.fr");
            }
        }
        return false;
    }

    /**
     *   Sécurisation d'un type "password"
     *
     * <p>  </p>
     *
     * @name form_Rules::secure_password()
     * @return string
     **/
    public function secure_password($val){
        $test = $this->secure_text($val);
        if($test && ctype_alnum($val) && !is_numeric($val) && !ctype_alpha($val)){
            return true;
        }elseif($test){
            $this->saveErrorMessage("il doit y avoir au moins une lettre et un chiffre");
            return false;
        }
        return false;
    }

    /**
     *   Si une chaine et vide ou non
     *
     * <p>  </p>
     *
     * @name form_Rules::ifNull()
     * @return string
     **/
    public function ifNull($val){
        if($val == null || $val == '')
            return true;
        else
            return false;
    }

    /**
     *   Validation selon type d'un retour formulaire et protections des résultats
     *
     * <p>  </p>
     *
     * @name form_Rules::inMaxMinLenght()
     * @return string
     **/
    public function inMaxMinLenght($val){
        if($this->minLength == null){return true;}
        if($this->maxLength == null){return true;}

        if( strlen($val) < $this->minLength){
            $this->saveErrorMessage("au moins ".$this->minLength." caractères est attendus" );
            return false;
        }else{
            if( strlen($val) > $this->maxLength){
                $this->saveErrorMessage("moins de ".$this->maxLength." caractères est attendus" );
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     *   Validation selon type d'un retour formulaire et protections des résultats
     *
     * <p>  </p>
     *
     * @name form_Rules::inMaxMin()
     * @return string
     **/
    public function inMaxMin($val){
        if($this->min == null){return true;}
        if($this->max == null){return true;}

        if( $val < $this->min){
            $this->saveErrorMessage("la valeur doit être supérieur a ".$this->min."." );
            return false;
        }else{
            if( $val > $this->max){
                $this->saveErrorMessage("la valeur doit être inférieur a ".$this->max."." );
                return false;
            }else{
                return true;
            }
        }
    }

    public function newFormatDate($date,$separator,$format){
        $f = @explode($separator, $this->format);
        foreach ($f as $k=>$v) {
            if($v[0] == "y") {
                if(strlen($v) > 2) {
                    $f[$k] = "Y";
                } else {
                    $f[$k] = "y";
                }
            }
            if ($v[0] == "d") $f[$k] = "d";
            if ($v[0] == "m") $f[$k] = "m";
        }
        $d = DateTime::createFromFormat($f[0].$separator.$f[1].$separator.$f[2], $date);
        return $d->format($format);
    }

    /**
     *   Sécurisation d'un type "texte"
     *
     * <p>  </p>
     *
     * @name form_Rules::validate_texte()
     * @return string
     **/
    public function saveErrorMessage($val){
        if($val == null){
            $this->save_error = false;
        }else{
            ($this->save_error == false || $this->save_error == null)?  $this->save_error = $val : $this->save_error .='<br/>'.$val ;
        }
        return $val;
    }

    /**
    *   Destructor
    *
    * <p> Destroy instance of class </p>
    *
    * @name form_Rules::__destruct()
    * @return void
    **/
    public function __destruct() {
        unset ($this);
    }
}
