<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class database_Object {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    public $connection;
    public $connected = false;

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name database_Object::__construct()
     * @param $server
     * @param $login
     * @param $mdp
     * @param $base
     * @param $port
     * @return void
     **/
    public function __construct($server = DATABASE_SERVER, $login = DATABASE_LOGIN, $mdp = DATABASE_PASSWORD, $base = BASE_TAG, $port = DATABASE_PORT) {
        try{
            $this->connection = new PDO(
                DATABASE_TYPE.':host='.DATABASE_SERVER.';port='.DATABASE_PORT.';dbname='.BASE_TAG,
                DATABASE_LOGIN,
                DATABASE_PASSWORD,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")
            );
            $this->connected = true;
        }catch(Exception $e){
            echo 'Connexion à la base échouée';
            die();
        }
    }

    /**
     *   select
     *
     * <p> Select rows from database </p>
     *
     * @name database_Object::select()
     * @param $sql
     * @param $format
     * @param $limit
     * @param $debut
     * @return if format = 1 : Object ; 2 : Array; 3 : Json; 4 : Class;
     **/
    public function select($sql,$format=1,$limit=0,$debut=0){
        if($limit > 0){
            if($debut > 0) $limit = " LIMIT $debut, $limit ";
            else $limit = " LIMIT $limit ";
        }else $limit = '';

        //TODO look to generate sql query

        $query = $this->connection->query($sql.$limit);

        switch($format){
            case 1:
                $rows = array();
                while( $row = $query->fetch(PDO::FETCH_OBJ) ){
                    $rows[] = $row;
                }
                if(sizeof($rows) == 1)
                    return $rows[0];
                return $rows;
                break;
            case 2:
                $rows = array();
                while( $row = $query->fetch(PDO::FETCH_ASSOC) ){
                    $rows[] = $row;
                }
                if(sizeof($rows) == 1)
                    return $rows[0];
                return $rows;
                break;
            case 3:
                $rows = array();
                while( $row = $query->fetch(PDO::FETCH_OBJ) ){
                    $rows[] = $row;
                }
                if(sizeof($rows) == 1)
                    return $rows[0];
                return json_encode($rows);
                break;
            case 4: //TODO adding class to laod correctly datas
                $rows = array();
                while( $row = $query->fetch(PDO::FETCH_CLASS) ){
                    $rows[] = $row;
                }
                if(sizeof($rows) == 1)
                    return $rows[0];
                return $rows;
                break;
        }
        return false;
    }

    /**
     *   insert
     *
     * <p> Insert row(s) to database from Array, String or object's modules</p>
     *
     * @name database_Object::insert()
     * @param $val(Array|String|Object)
     * @param $tbname(String):false
     * @return boolean
     **/
    public function insert($val,$tbname = false){
        if(is_array($val)){
            $this->begin();
            $query = true;
            $result = '';
            foreach($val as $value){
                $rslt = $this->connection->exec($this->getSqlInsert($value,$tbname));
                if(!$rslt){
                    $this->rollback();
                    $query = false;
                }else
                    $result .= $rslt;
            }
            if($query){
                $this->commit();
                $query = $result;
            }else $query = false;
        }else{
            $sql = $this->getSqlInsert($val,$tbname);
            $this->connection->exec($sql);
            $query = $this->lastInsertId();

        }
        return $query;
    }

    /**
     *   getSqlInsert
     *
     * <p> Create SQL for Insert query </p>
     *
     * @name database_Object::getSqlInsert()
     * @param $a
     * @param $b
     * @return boolean
     **/
    private function getSqlInsert($a,$b){
        if(is_string($a)){
            return $a;
        }elseif(is_object($a)){
            if(is_string($b))$table = $b;
            else $table = get_class($a);
            $cols = array();
            $vals = array();
            foreach($a as $key => $value) {
                if(!is_null($value)){
                    $cols[] =' '.$key;
                    if(is_string($value))$vals[] =' \''.$value.'\'';
                    else $vals[] =' '.$value ;
                }
            }
            $sql = "INSERT INTO ".$table." (".implode($cols,",").") \n VALUES (".implode($vals,",").");\n";
            return $sql;
        }else{
            return false;
        }
    }

    /**
     *   update
     *
     * <p> Update row(s) frow database from (Array of) string or object's modules.
     *     Default name's table is modules's name</p>
     *
     * @name database_Object::update()
     * @param $val(Array|String|Object)
     * @param $condition(Number|String):false
     * @param $tbname(String):false
     * @return boolean
     **/
    public function update($val,$condition = false,$tbname = false){
        if(is_array($val)){
            $this->begin();
            $query = true;
            $result = '';
            foreach($val as $value){
                $rslt = $this->connection->exec($this->getSqlUpdate($value,$condition,$tbname));
                if(!$rslt){
                    $this->rollback();
                    $query = false;
                }else
                    $result = $rslt;
            }
            if($query){
                $this->commit();
                $query = $result;
            }else $query = false;
        }else{
            $sql = $this->getSqlUpdate($val,$condition, $tbname);
            $query = $this->connection->exec($sql);
        }
        return $query;
    }

    /**
     *   getSqlUpdate
     *
     * <p> Create SQL for update query </p>
     *
     * @name database_Object::getSqlUpdate()
     * @return boolean
     **/
    private function getSqlUpdate($a,$c,$b){
        if(is_string($a)){
            return $a;
        }elseif(is_object($a)){
            if(is_string($b))$table = $b;
            else $table = get_class($a);
            $vals = array();
            $libKey = false;
            foreach($a as $key => $value) {
                if(!is_null($value)){
                    //recupération du nom de ligne pour l'index
                    if(!is_string($libKey)){
                        if(substr_count($key,DATABASE_CHAR_SEPARATOR) > 0)
                            $libKey = @preg_split(DATABASE_CHAR_SEPARATOR,$key);
                        else
                            $libKey = array(0 => $key);

                        if($libKey[0] == 'id'){
                            $libKey = $key;
                        }
                    }
                    $col =' '.$key.' =';
                    if(is_string($value))$col .=' \''.$value.'\'';
                    else $col .=' '.$value;
                    $vals[] = $col;
                }
            }
            $sql = 'UPDATE '.$table.'
            SET '.implode($vals,',');
            if(is_string($libKey) && ($c && is_numeric($c)))$sql .=' WHERE '.$libKey.' = '.$c;
            elseif(is_string($c))$sql .=' WHERE '.$c;
            $sql .= ';';
            return $sql;
        }else{
            return false;
        }
    }

    /**
     *   delete
     *
     * <p> Delete one row from Database </p>
     *
     * @name database_Object::delete()
     * @return boolean
     **/
    public function delete($val,$condition = false,$tbname = false){
        if(is_array($val)){
            $this->begin();
            $query = true;
            $result = '';
            foreach($val as $value){
                $rslt = $this->connection->exec($this->getSqlDelete($value,$condition,$tbname));
                if(!$rslt){
                    $this->rollback();
                    $query = false;
                }else
                    $result = $rslt;
            }
            if($query){
                $this->commit();
                $query = $result;
            }else $query = false;
        }else{
            $sql = $this->getSqlDelete($val,$condition, $tbname);
            $query = $this->connection->exec($sql);
        }
        return $query;
    }

    /**
     *   getSqlDelete
     *
     * <p> Create SQL for delete query </p>
     *
     * @name database_Object::getSqlDelete()
     * @return boolean
     **/
    private function getSqlDelete($a,$c,$b){
        if(is_string($a)){
            return $a;
        }elseif(is_object($a)){
            if(is_string($b))$table = $b;
            else $table = get_class($a);
            $vals = array();
            $libKey = false;
            foreach($a as $key => $value) {
                // recupération du nom de ligne pour l'index
                if(!is_string($libKey)){
                    if(substr_count($key,DATABASE_CHAR_SEPARATOR) > 0)
                        $libKey = @preg_split(DATABASE_CHAR_SEPARATOR,$key);
                    else $libKey = array(0 => $key);
                    if($libKey[0] == 'id'){
                        $libKey = $key;
                    }
                }
            }
            $sql = 'DELETE FROM '.$table.' ';
            if(is_string($libKey) && ($c && is_numeric($c)))$sql .=' WHERE '.$libKey.' = '.$c;
            elseif(is_string($c))$sql .=' WHERE '.$c;
            $sql .= ';';
            return $sql;
        }else{
            return false;
        }
    }

    public function formatTimestamp($timestamp){
        return date(FORMAT_DATE_BDD,$timestamp);
    }

    /**
     *   Destructor
     *
     * <p> Destroy instance of class </p>
     *
     * @name database_Object::__destruct()
     * @return void
     **/
    public function __destruct() {

        $this->connection = null;
        unset($this);
    }
}
?>
