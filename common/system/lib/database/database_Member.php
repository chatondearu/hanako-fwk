<?php


/**
 *
 * détail
 *
 * <p>***</p>
 *
 * @name me_member
 * @author Romain Lienard <rlienard@keyneosoft.fr>
 * @http://keyneosoft.com
 * @copyright Romain Lienard Keyneosoft 2011
 * @version 0.0.0
 * @package me_member
 * @date: 23/04/12
 * @time: 11:01
 *
 **/

class database_Member {


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
    * @var (String)
    * @desc ;
    */
    protected $primaryKey = null;
    protected $tableName = null;

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name me_member::__construct()
     * @return void
     **/
    public function __construct() {
    
    }

    public function get($var=null){
        if(is_null($var)){
            $var = array();

            foreach($this as $key=>$val){
                $var[$key] = $val;
            }
            return $var;
        }else{
            return $this->{$var};
        }
    }

    public function set($var,$value = null){
        if(is_array($var)){
            $i=0;
            foreach($this as $key=>$val){
                if($key != "primaryKey" && $key != "tableName"){
                    $this->{$key} =(array_key_exists($i,$var))?$var[$i]:$var[$key];
                    $i++;
                }
            }
        }else{
            $this->{$var} = $value;
        }
    }

    public function getDbLine($id){
        global $db;
        if(is_null($this->primaryKey)) return false;
        $result = $db->select('SELECT *
                    FROM  '.$this->tableName.'
                    WHERE  '.$this->primaryKey.' = '.$id);
        $this->set($result);
    }

    public function update(){
        global $db;
        $db->update($this->getObject(), $this->primaryKey.' = '.$this->{$this->primaryKey},$this->tableName);
    }

    public function insert(){
        global $db;
        $db->insert($this->getObject(),$this->tableName);
    }

    protected function getObject(){
        foreach($this as $key=>$val){
            if($key != "primaryKey" && $key != "tableName"){
                ${get_class($this)}->{$key} = $this->{$key};
            }
        }
        return ${get_class($this)};
    }
    
    /**
    *   Destructor
    *
    * <p> Destroy instance of class </p>
    *
    * @name me_member::__destruct()
    * @return void
    **/
    public function __destruct() {
        
    }
}
