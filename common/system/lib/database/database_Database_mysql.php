<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class database_database {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
    * @var (Object Database_connection)
    * @desc instance of link to database;
    */
    private $link;
    /**
    * @var (Object Database_connection)
    * @desc instance of connection with base;
    */
    private $connected;

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   query
     *
     * <p> function query with database </p>
     *
     * @name me_database::query()
     * @return data
     **/
    protected function query($sql){
        $query = mysql_query($sql,$this->link) OR die(mysql_error());
        return $query;
    }

    protected function lastInsertId(){
        return mysql_insert_id();
    }

    /**
     *   fetch_row
     *
     * <p> function Fetch Row results from query </p>
     *
     * @name me_database::fetch_row()
     * @return row
     **/
    protected function fetchRow($query){
        return mysql_fetch_row($query);
    }

    /**
     *   fetch_array
     *
     * <p> function Fetch Array results from query </p>
     *
     * @name me_database::fetch_array()
     * @return Array
     **/
    protected function fetchArray($query){
        return mysql_fetch_array($query);
    }

    /**
     *   fetch_object
     *
     * <p> function Fetch Array results from query </p>
     *
     * @name me_database::fetch_object()
     * @return Array
     **/
    protected function fetchObject($query){
        return mysql_fetch_object($query);
    }

    /**
     *   connect
     *
     * <p> function connect with database </p>
     *
     * @name me_database::connect()
     * @return data
     **/
    protected function connect( $server, $login, $mdp, $ifNewLink, $client ){
        $this->link = mysql_connect( $server, $login, $mdp, $ifNewLink, $client ) OR die(mysql_error());
        return true;
    }

    /**
     *   disconnect
     *
     * <p> function close database </p>
     *
     * @name me_database::connect()
     * @return data
     **/
    protected function disconnect(  ){
        mysql_close($this->getLink());
        return true;
    }

    /**
     *   selectdb
     *
     * <p> function connect with database </p>
     *
     * @name me_database::connect()
     * @return data
     **/
    protected function selectdb($base){
        if(!$this->link){ return false; }
        $this->connected = mysql_select_db( $base, $this->link ) OR die(mysql_error());
        if(!$this->connected) { die('Erreur critique: Database Error<br />' . mysql_error()); }
        return true;
    }

    /**
     *   begin
     *
     * <p> Start transaction</p>
     *
     * @name me_database::begin()
     * @return
     **/
    protected function begin(){
        return $this->query("BEGIN");
    }

    /**
     *   commit
     *
     * <p> Start transaction</p>
     *
     * @name me_database::commit()
     * @return
     **/
    protected function commit(){
        return $this->query("COMMIT");
    }

    /**
     *   rollback
     *
     * <p> Start transaction</p>
     *
     * @name me_database::rollback()
     * @return
     **/
    protected function rollback(){
        return $this->query("ROLLBACK");
    }

    /**
     *   getLink
     *
     * <p> get link from this </p>
     *
     * @name me_database::getLink()
     * @return $this::link
     **/
    protected function getLink(){
        return $this->link;
    }

    /**
     *   getConnection
     *
     * <p> get connected from this </p>
     *
     * @name me_database::getConnection()
     * @return $this::connected
     **/
    protected function getConnection(){
        return $this->connected;
    }
}

?>