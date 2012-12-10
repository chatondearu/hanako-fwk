<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*
 *
 *

 //Create
$user = new User();
$user->set('username','user');
$user->set('password','password');
$user->create();
$uid=$user->get('uid');

//Update
$user->set('password','newpassword');
$user->update();

//Retrieve, Delete, Exists
$user = new User();
$user->retrieve($uid);
if ($user->exists())
  $user->delete();

//Retrieve based on other criteria than the PK
$user = new User();
$user->retrieve_one("username=?",'erickoh');
$user->retrieve_one("username=? AND password=? AND status='enabled'",array('erickoh','123456'));

//Return an array of Model objects
$user = new User();
$user_array = $user->retrieve_many("username LIKE ?",'eric%');
foreach ($user_array as $user)
  $user->delete();

//Return selected fields as array
$user = new User();
$result_array = $user->select("username,email","username LIKE ?",'eric%');
print_r($result_array);

 *
 *
 *  */


//===============================================================
// Model/ORM
// Requires a function getdb() which will return a PDO handler
/*
function getdb() {
  if (!isset($GLOBALS['dbh']))
    try {
      //$GLOBALS['dbh'] = new PDO('sqlite:'.APP_PATH.'db/dbname.sqlite');
      $GLOBALS['dbh'] = new PDO('mysql:host=localhost;dbname=dbname', 'username', 'password');
    } catch (PDOException $e) {
      die('Connection failed: '.$e->getMessage());
    }
  return $GLOBALS['dbh'];
}
*/
//===============================================================

abstract class hnk_Model  {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/
    
    protected $keyName;
    protected $tableName;
    protected $db_fn;
    
    protected $QUOTE_STYLE='MYSQL'; // valid types are MYSQL,MSSQL,ANSI
    protected $COMPRESS_ARRAY=true;
    
    public $rs = array(); // for holding all object property variables


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name hnk_Model::__construct()
     **/
    function __construct($keyName='', $tableName='', $db_fn='hnk_getDB', $quote_style='MYSQL', $compress_array=true) {
        
        $this->keyName=$keyName;
        $this->tableName=$tableName;
        $this->db_fn=$db_fn;
        $this->QUOTE_STYLE=$quote_style;
        $this->COMPRESS_ARRAY=$compress_array;
        
    }

    function get($key) {
        return $this->rs[$key];
    }

    function set($key, $val) {
        if (isset($this->rs[$key]))
            $this->rs[$key] = $val;
        return $this;
    }

    function __get($key) {
        return $this->get($key);
    }

    function __set($key, $val) {
        return $this->set($key,$val);
    }

    protected function getdb() {
        return call_user_func($this->db_fn);
    }

    protected function enquote($name) {
        if ($this->QUOTE_STYLE=='MYSQL')
            return '`'.$name.'`';
        elseif ($this->QUOTE_STYLE=='MSSQL')
            return '['.$name.']';
        else
            return '"'.$name.'"';
    }

    //Inserts record into database with a new auto-incremented primary key
    //If the primary key is empty, then the PK column should have been set to auto increment
    function create() {
        $dbh=$this->getdb();
        $keyName=$this->keyName;
        $s1=$s2='';
        foreach ($this->rs as $k => $v)
            if ($k!=$keyName || $v) {
                $s1 .= ','.$this->enquote($k);
                $s2 .= ',?';
            }
        $sql = 'INSERT INTO '.$this->enquote($this->tableName).' ('.substr($s1,1).') VALUES ('.substr($s2,1).')';
        $stmt = $dbh->prepare($sql);
        $i=0;
        foreach ($this->rs as $k => $v)
            if ($k!=$keyName || $v)
                $stmt->bindValue(++$i,is_scalar($v) ? $v : ($this->COMPRESS_ARRAY ? gzdeflate(serialize($v)) : serialize($v)) );
        $stmt->execute();
        if (!$stmt->rowCount())
            return false;
        $this->set($keyName,$dbh->lastInsertId());
        return $this;
    }

    function retrieve($pkvalue) {
        $dbh=$this->getdb();
        $sql = 'SELECT * FROM '.$this->enquote($this->tableName).' WHERE '.$this->enquote($this->keyName).'=?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,(int)$pkvalue);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($rs)
            foreach ($rs as $key => $val)
                if (isset($this->rs[$key]))
                    $this->rs[$key] = is_scalar($this->rs[$key]) ? $val : unserialize($this->COMPRESS_ARRAY ? gzinflate($val) : $val);
        return $this;
    }

    function update() {
        $dbh=$this->getdb();
        $s='';
        foreach ($this->rs as $k => $v)
            $s .= ','.$this->enquote($k).'=?';
        $s = substr($s,1);
        $sql = 'UPDATE '.$this->enquote($this->tableName).' SET '.$s.' WHERE '.$this->enquote($this->keyName).'=?';
        $stmt = $dbh->prepare($sql);
        $i=0;
        foreach ($this->rs as $k => $v)
            $stmt->bindValue(++$i,is_scalar($v) ? $v : ($this->COMPRESS_ARRAY ? gzdeflate(serialize($v)) : serialize($v)) );
        $stmt->bindValue(++$i,$this->rs[$this->keyName]);
        return $stmt->execute();
    }

    function delete() {
        $dbh=$this->getdb();
        $sql = 'DELETE FROM '.$this->enquote($this->tableName).' WHERE '.$this->enquote($this->keyName).'=?';
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1,$this->rs[$this->keyName]);
        return $stmt->execute();
    }

    //returns true if primary key is a positive integer
    //if checkdb is set to true, this function will return true if there exists such a record in the database
    function exists($checkdb=false) {
        if ((int)$this->rs[$this->keyName] < 1)
            return false;
        if (!$checkdb)
            return true;
        $dbh=$this->getdb();
        $sql = 'SELECT 1 FROM '.$this->enquote($this->tableName).' WHERE '.$this->enquote($this->keyName)."='".$this->rs[$this->keyName]."'";
        $result = $dbh->query($sql)->fetchAll();
        return count($result);
    }

    function merge($arr) {
        if (!is_array($arr))
            return $this;
        foreach ($arr as $key => $val)
            if (isset($this->rs[$key]))
                $this->rs[$key] = $val;
        return $this;
    }

    function retrieve_one($wherewhat='',$bindings='') {
        $dbh=$this->getdb();
        if (is_scalar($bindings))
            $bindings= trim($bindings) ? array($bindings) : array();
        $sql = 'SELECT * FROM '.$this->enquote($this->tableName);
        if ($wherewhat)
            $sql .= ' WHERE '.$wherewhat;
        $sql .= ' LIMIT 1';
        $stmt = $dbh->prepare($sql);
        $i=0;
        foreach($bindings as $v)
            $stmt->bindValue(++$i,$v);
        $stmt->execute();
        $rs = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$rs)
            return false;
        foreach ($rs as $key => $val)
            if (isset($this->rs[$key]))
                $this->rs[$key] = is_scalar($this->rs[$key]) ? $val : unserialize($this->COMPRESS_ARRAY ? gzinflate($val) : $val);
        return $this;
    }

    function retrieve_many($wherewhat='',$bindings='') {
        $dbh=$this->getdb();
        if (is_scalar($bindings))
            $bindings=trim($bindings) ? array($bindings) : array();
        $sql = 'SELECT * FROM '.$this->tableName;
        if ($wherewhat)
            $sql .= ' WHERE '.$wherewhat;
        $stmt = $dbh->prepare($sql);
        $i=0;
        foreach($bindings as $v)
            $stmt->bindValue(++$i,$v);
        $stmt->execute();
        $arr=array();
        $class=get_class($this);
        while ($rs = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $myclass = new $class();
            foreach ($rs as $key => $val)
                if (isset($myclass->rs[$key]))
                    $myclass->rs[$key] = is_scalar($myclass->rs[$key]) ? $val : unserialize($this->COMPRESS_ARRAY ? gzinflate($val) : $val);
            $arr[]=$myclass;
        }
        return $arr;
    }

    function select($selectwhat='*',$wherewhat='',$bindings='',$pdo_fetch_mode=PDO::FETCH_ASSOC) {
        $dbh=$this->getdb();
        if (is_scalar($bindings))
            $bindings=trim($bindings) ? array($bindings) : array();
        $sql = 'SELECT '.$selectwhat.' FROM '.$this->tableName;
        if ($wherewhat)
            $sql .= ' WHERE '.$wherewhat;
        $stmt = $dbh->prepare($sql);
        $i=0;
        foreach($bindings as $v)
            $stmt->bindValue(++$i,$v);
        $stmt->execute();
        return $stmt->fetchAll($pdo_fetch_mode);
    }

}