<?php

    //paramettre
    define("MODULENAME",'soft');

    print_r(sizeof( explode(SEPARATOR_REALPATH,realpath('.')) ) - sizeof( explode(SEPARATOR_REALPATH,dirname(__DIR__)) ));

    $wayToRealpath = '';
    for($i=0 ; $i < sizeof( explode(SEPARATOR_REALPATH,realpath('.')) ) - sizeof( explode(SEPARATOR_REALPATH,dirname(__DIR__)) ); $i++){
        $wayToRealpath .= '../';
    }
    define("MODULE_PRINCIPAL_PATH",$wayToRealpath.MODULES_PATH.MODULENAME.'/class/');

    function CreateMemberClass($name,$columns = array()){
        $nameId = null;

        $class = '<?php'."\n\n";
        $class.= 'class '.MODULENAME.'_'.$name.' {'."\n\n";

        $titleproprieties = "\t".'/*~*~*~*~*~*~*~*~*~*~*/'."\n";
        $titleproprieties.= "\t".'/*  1. proprieties   */'."\n";
        $titleproprieties.= "\t".'/*~*~*~*~*~*~*~*~*~*~*/';
        $prorieties = '';
        foreach($columns as $cols){
            $prorieties.= "\t".'public $'.$cols['Field'];
            if( $cols['Key'] == "PRI"){
                $prorieties.= ' = -1';
                if($nameId == null)
                    $nameId = $cols['Field'];
            }elseif( $cols['Default'] != ''){
                if($cols['Default'] == 'CURRENT_TIMESTAMP')
                    $prorieties.= ' = \'\'';
                else
                    $prorieties.= ' = '.$cols['Default'];
            }elseif( $cols['Null'] != "NO")
                $prorieties.= ' = NULL';
            $prorieties.= ';'."\n";
        }
        $titlemethods = "\t".'/*~*~*~*~*~*~*~*~*~*~*/'."\n";
        $titlemethods.= "\t".'/*  2.methods        */'."\n";
        $titlemethods.= "\t".'/*~*~*~*~*~*~*~*~*~*~*/';

        $constructor = "\t".'/**'."\n";
        $constructor.= "\t".' *   Constructor'."\n";
        $constructor.= "\t".' *'."\n";
        $constructor.= "\t".' * <p> Construct instance of class </p>'."\n";
        $constructor.= "\t".' *'."\n";
        $constructor.= "\t".' * @name '.MODULENAME.'_'.$name.'::__construct()'."\n";
        $constructor.= "\t".' * @return void'."\n";
        $constructor.= "\t".' **/'."\n";
        if($nameId == null){
            $constructor.= "\t".'public function __construct(';
            foreach($columns as $key=>$cols){
                $constructor.= '$'.$cols['Field'].'=-1';
                if($key != sizeof($columns)-1)
                    $constructor.=',';
            }
            $constructor.= ') {'."\n";
            $constructor.= "\t\t".'if(';
            foreach($columns as $key=>$cols){
                $constructor.= '$'.$cols['Field'].' > -1 ';
                if($key != sizeof($columns)-1)
                    $constructor.='&& ';
            }
            $constructor.= '){'."\n";
            $constructor.= "\t\t\t".'$this->getByIdFromDB(';
            foreach($columns as $key=>$cols){
                $constructor.= '$'.$cols['Field'];
                if($key != sizeof($columns)-1)
                    $constructor.=',';
            }
            $constructor.= ');'."\n";

        }else{
            $constructor.= "\t".'public function __construct($id=-1) {'."\n";
            $constructor.= "\t\t".'if($id > -1){'."\n";
            $constructor.= "\t\t\t".'$this->getByIdFromDB($id);'."\n";
        }
        $constructor.= "\t\t".'}'."\n";
        $constructor.= "\t".'}'."\n";

        //TODO private functions
        /*
        public function langage_exemple(){
            return $this->exemple_exemple;
        }

        public function set_langage_exemple($val){
            $this->exemple_exemple = $val;
            $this->exemple_id_exemple = $val->id_exemple;
        }
        */
        
        $get = "\t".'public function get(){'."\n";
        $get.= "\t\t".'return array('."\n";
        foreach($columns as $cols){
            $get.= "\t\t\t".'"'.$cols["Field"].'" => $this->'.$cols["Field"].','."\n";
        }
        $get.= "\t\t".');'."\n";
        $get.= "\t".'}'."\n";

        $set = "\t".'public function set(';
        foreach($columns as $key=>$cols){
            $set.= '$'.$cols['Field'];
            if($key != sizeof($columns)-1)
                $set.=',';
        }
        $set.= '){'."\n";
        foreach($columns as $cols){
            $set.= "\t\t".'$this->'.$cols['Field'].' = $'.$cols['Field'].';'."\n";
        }
        //TODO add private membre to set function
        $set.= "\t".'}'."\n";

        if($nameId == null){
            $getByIdFromDB = "\t".'public function getByIdFromDB(';
            foreach($columns as $key=>$cols){
                $getByIdFromDB.= '$'.$cols['Field'];
                if($key != sizeof($columns)-1)
                    $getByIdFromDB.=',';
            }
            $getByIdFromDB.= '){'."\n";
            $getByIdFromDB.= "\t\t".'global $db;'."\n";
            $getByIdFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' WHERE ';
            foreach($columns as $key=>$cols){
                if($cols['Type'] == 'text' ||
                    $cols['Type'] == 'varchar')
                    $getByIdFromDB.= $cols['Field'].' = \\\'\'.$'.$cols['Field'].'.\'\\\'';
                else
                    $getByIdFromDB.= $cols['Field'].' = \'.$'.$cols['Field'].'.\'';
                if($key != sizeof($columns)-1)
                    $getByIdFromDB.=' AND ';
            }
            $getByIdFromDB.=';\',1);'."\n";
            $getByIdFromDB.= "\t\t".'if(sizeof($result) > 0){'."\n";
            $getByIdFromDB.= "\t\t\t".'$this->set(';
            for($i = 0; $i < sizeof($columns); $i++){
                $getByIdFromDB.= '$result['.$i.']';
                if($i != sizeof($columns)-1)
                    $getByIdFromDB.=',';
            }
            $getByIdFromDB.= ");\n";
            $getByIdFromDB.= "\t\t\t".'return $this->get();'."\n";
            $getByIdFromDB.= "\t\t".'}else return false;'."\n";
            $getByIdFromDB.= "\t}\n";
        }else{
            $getByIdFromDB = "\t".'public function getByIdFromDB($id){'."\n";
            $getByIdFromDB.= "\t\t".'global $db;'."\n";
            $getByIdFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' WHERE '.$nameId.' = \'.$id.\';\',1);'."\n";
            $getByIdFromDB.= "\t\t".'if(sizeof($result) > 0){'."\n";
            $getByIdFromDB.= "\t\t\t".'$this->set(';
            for($i = 0; $i < sizeof($columns); $i++){
                $getByIdFromDB.= '$result['.$i.']';
                if($i != sizeof($columns)-1)
                    $getByIdFromDB.=', ';
            }
            $getByIdFromDB.= ");\n";
            $getByIdFromDB.= "\t\t\t".'return $this->get();'."\n";
            $getByIdFromDB.= "\t\t".'}else return false;'."\n";
            $getByIdFromDB.= "\t}\n";
        }


        $attributeSecurity = "\t".'private function attributeSecurity(){'."\n";
        $attributeSecurity.= "\t\t".'//add Security for all Atributes here'."\n";
        foreach($columns as $cols){
            $attributeSecurity.= "\t\t".'$this->'.$cols['Field'].' = $this->'.$cols['Field'].';'."\n";
        }
        $attributeSecurity.= "\t}\n";

        $insert = "\t".'public function insert(){'."\n";
        $insert.= "\t\t".'global $db;'."\n";
        if($nameId != null){
            $insert.= "\t\t".'if( $this->'.$nameId.' < 0)'."\n";
            $insert.= "\t\t\t".'$this->'.$nameId.' = \'\';'."\n";
        }
        $insert.= "\t\t".'$this->attributeSecurity();'."\n";
        $insert.= "\t\t".'return $db->insert($this,\''.$name.'\');'."\n";
        $insert.= "\t}\n";

        if($nameId == null){
            $update = "\t".'public function update(){'."\n";
            $update.= "\t\t".'global $db;'."\n";
            $update.= "\t\t".'$this->attributeSecurity();'."\n";
            $update.= "\t\t".'return $db->update($this,';
            $update.= '\' WHERE ';
            foreach($columns as $key=>$cols){
                if($cols['Type'] == 'text' ||
                    $cols['Type'] == 'varchar')
                    $update.= $cols['Field'].' = \\\'\'.$this->'.$cols['Field'].'.\'\\\'';
                else
                    $update.= $cols['Field'].' = \'.$this->'.$cols['Field'].'.\'';
                if($key != sizeof($columns)-1)
                    $update.=' AND ';
            }
            $update.=' \',\''.$name.'\');'."\n";
            $update.= "\t}\n";
        }else{
            $update = "\t".'public function update(){'."\n";
            $update.= "\t\t".'global $db;'."\n";
            $update.= "\t\t".'$this->attributeSecurity();'."\n";
            $update.= "\t\t".'return $db->update($this,$this->'.$nameId.',\''.$name.'\');'."\n";
            $update.= "\t}\n";
        }

        if($nameId == null){
            $delete = "\t".'public function delete(){'."\n";
            $delete.= "\t\t".'global $db;'."\n";
            $delete.= "\t\t".'return $db->delete($this,';
            $delete.= '\' WHERE ';
            foreach($columns as $key=>$cols){
                if($cols['Type'] == 'text' ||
                    $cols['Type'] == 'varchar')
                    $delete.= $cols['Field'].' = \\\'\'.$this->'.$cols['Field'].'.\'\\\'';
                else
                    $delete.= $cols['Field'].' = \'.$this->'.$cols['Field'].'.\'';
                if($key != sizeof($columns)-1)
                    $delete.=' AND ';
            }
            $delete.=' \',\''.$name.'\');'."\n";
            $delete.= "\t}\n";
        }else{
            $delete = "\t".'public function delete(){'."\n";
            $delete.= "\t\t".'global $db;'."\n";
            $delete.= "\t\t".'return $db->delete($this,$this->'.$nameId.',\''.$name.'\');'."\n";
            $delete.= "\t}\n";
        }

        $destructor = "\t".'/**'."\n";
        $destructor.= "\t".'*   Destructor'."\n";
        $destructor.= "\t".'*'."\n";
        $destructor.= "\t".'* <p> Destroy instance of class </p>'."\n";
        $destructor.= "\t".'*'."\n";
        $destructor.= "\t".'* @name '.MODULENAME.'_'.$name.'::__destruct()'."\n";
        $destructor.= "\t".'* @return void'."\n";
        $destructor.= "\t".'**/'."\n";
        $destructor.= "\t".'public function __destruct() {'."\n";
        $destructor.= "\t\t".'unset($this);'."\n";
        $destructor.= "\t}\n";

        $class.= $titleproprieties."\n\n";
        $class.= $prorieties."\n";
        $class.= $titlemethods."\n\n";
        $class.= $constructor."\n";
        $class.= $get."\n";
        $class.= $set."\n";
        $class.= $getByIdFromDB."\n";
        $class.= $attributeSecurity."\n";
        $class.= $insert."\n";
        $class.= $update."\n";
        $class.= $delete."\n";
        $class.= $destructor."\n";

        $class.= "}\n\n";
        $class.= '?>';

        return $class;

    }

    function CreateCollectionClass($name,$columns = array()){
        $nameId = null;
        foreach($columns as $cols){
            if( $cols['Key'] == "PRI"){
                if($nameId == null)
                    $nameId = $cols['Field'];
            }
        }

        $class = '<?php'."\n\n";
        $class.= 'class '.MODULENAME.'_c'.$name.' {'."\n";

        $titleproprieties = "\t".'/*~*~*~*~*~*~*~*~*~*~*/'."\n";
        $titleproprieties.= "\t".'/*  1. proprieties   */'."\n";
        $titleproprieties.= "\t".'/*~*~*~*~*~*~*~*~*~*~*/';
        $prorieties = "\t".'private $collection = array();'."\n";

        $titlemethods = "\t".'/*~*~*~*~*~*~*~*~*~*~*/'."\n";
        $titlemethods.= "\t".'/*  2.methods        */'."\n";
        $titlemethods.= "\t".'/*~*~*~*~*~*~*~*~*~*~*/';

        $constructor = "\t".'/**'."\n";
        $constructor.= "\t".' *   Constructor'."\n";
        $constructor.= "\t".' *'."\n";
        $constructor.= "\t".' * <p> Construct instance of class </p>'."\n";
        $constructor.= "\t".' *'."\n";
        $constructor.= "\t".' * @name '.MODULENAME.'_c'.$name.'::__construct()'."\n";
        $constructor.= "\t".' * @return void'."\n";
        $constructor.= "\t".' **/'."\n";
        $constructor.= "\t".'public function __construct() {'."\n";
        $constructor.= "\t}\n";

        $set = "\t".'function set($array){'."\n";
        $set.= "\t\t".'$passe = true;'."\n";
        $set.= "\t\t".'foreach($array as $obj){'."\n";
        $set.= "\t\t\t".'if(get_class($obj) != "'.MODULENAME.'_'.$name.'"){'."\n";
        $set.= "\t\t\t\t".'$passe = false;'."\n";
        $set.= "\t\t\t".'}'."\n";
        $set.= "\t\t".'}'."\n";
        $set.= "\t\t".'if($passe)'."\n";
        $set.= "\t\t\t".'$this->collection = $array;'."\n";
        $set.= "\t\t".'else return false;'."\n";
        $set.= "\t\t".'return true;'."\n";
        $set.= "\t}\n";

        $get = "\t".'public function get(){'."\n";
        $get.= "\t\t".'return $this->collection;'."\n";
        $get.= "\t".'}'."\n";

        $getAllFromDB = "\t".'public function getAllFromDB(){'."\n";
        $getAllFromDB.= "\t\t".'global $db;'."\n";
        $getAllFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.'\',3);'."\n";
        $getAllFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getAllFromDB.= "\t\t".'return $this->collection;'."\n";
        $getAllFromDB.= "\t}\n";

        $getByLimitFromDB = "\t".'public function getByLimitFromDB($limit){'."\n";
        $getByLimitFromDB.= "\t\t".'global $db;'."\n";
        $getByLimitFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.'\',3,$limit,0);'."\n";
        $getByLimitFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getByLimitFromDB.= "\t\t".'return $this->collection;'."\n";
        $getByLimitFromDB.= "\t}\n";

        $getAllDescFromDB = "\t".'public function getAllDescFromDB(){'."\n";
        $getAllDescFromDB.= "\t\t".'global $db;'."\n";
        $getAllDescFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' ORDER BY id_scripts DESC\',3);'."\n";
        $getAllDescFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getAllDescFromDB.= "\t\t".'return $this->collection;'."\n";
        $getAllDescFromDB.= "\t}\n";

        $getByLimitDescFromDB = "\t".'public function getByLimitDescFromDB($limit){'."\n";
        $getByLimitDescFromDB.= "\t\t".'global $db;'."\n";
        $getByLimitDescFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' ORDER BY id_scripts DESC\',3,$limit,0);'."\n";
        $getByLimitDescFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getByLimitDescFromDB.= "\t\t".'return $this->collection;'."\n";
        $getByLimitDescFromDB.= "\t}\n";

        $getAllOrderByFromDB = "\t".'public function getAllOrderByFromDB($colone){'."\n";
        $getAllOrderByFromDB.= "\t\t".'global $db;'."\n";
        $getAllOrderByFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' ORDER BY \'.$colone,3);'."\n";
        $getAllOrderByFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getAllOrderByFromDB.= "\t\t".'return $this->collection;'."\n";
        $getAllOrderByFromDB.= "\t}\n";

        $getByLimitOrderByFromDB = "\t".'public function getByLimitOrderByFromDB($colone,$limit){'."\n";
        $getByLimitOrderByFromDB.= "\t\t".'global $db;'."\n";
        $getByLimitOrderByFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' ORDER BY \'.$colone,3,$limit,0);'."\n";
        $getByLimitOrderByFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getByLimitOrderByFromDB.= "\t\t".'return $this->collection;'."\n";
        $getByLimitOrderByFromDB.= "\t}\n";

        $getAllOrderByDescFromDB = "\t".'public function getAllOrderByDescFromDB($colone){'."\n";
        $getAllOrderByDescFromDB.= "\t\t".'global $db;'."\n";
        $getAllOrderByDescFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' ORDER BY \'.$colone.\' DESC\',3);'."\n";
        $getAllOrderByDescFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getAllOrderByDescFromDB.= "\t\t".'return $this->collection;'."\n";
        $getAllOrderByDescFromDB.= "\t}\n";

        $getByLimitOrderByDescFromDB = "\t".'public function getByLimitOrderByDescFromDB($colone,$limit){'."\n";
        $getByLimitOrderByDescFromDB.= "\t\t".'global $db;'."\n";
        $getByLimitOrderByDescFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' ORDER BY \'.$colone.\' DESC\',3,$limit,0);'."\n";
        $getByLimitOrderByDescFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getByLimitOrderByDescFromDB.= "\t\t".'return $this->collection;'."\n";
        $getByLimitOrderByDescFromDB.= "\t}\n";

        $getAllWhereFromDB = "\t".'public function getAllWhereFromDB($condition){'."\n";
        $getAllWhereFromDB.= "\t\t".'global $db;'."\n";
        $getAllWhereFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' WHERE \'.$condition ,3);'."\n";
        $getAllWhereFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getAllWhereFromDB.= "\t\t".'return $this->collection;'."\n";
        $getAllWhereFromDB.= "\t}\n";

        $getWhereOrderByFromDB = "\t".'public function getWhereOrderByFromDB($condition,$colone){'."\n";
        $getWhereOrderByFromDB.= "\t\t".'global $db;'."\n";
        $getWhereOrderByFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' WHERE \'.$condition.\' ORDER BY \'.$colone ,3);'."\n";
        $getWhereOrderByFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getWhereOrderByFromDB.= "\t\t".'return $this->collection;'."\n";
        $getWhereOrderByFromDB.= "\t}\n";

        $getWhereOrderByDescFromDB = "\t".'public function getWhereOrderByDescFromDB($condition,$colone){'."\n";
        $getWhereOrderByDescFromDB.= "\t\t".'global $db;'."\n";
        $getWhereOrderByDescFromDB.= "\t\t".'$result = $db->select(\'SELECT * FROM '.$name.' WHERE \'.$condition.\' ORDER BY \'.$colone.\' DESC\' ,3);'."\n";
        $getWhereOrderByDescFromDB.= "\t\t".'$this->addToCollectionFromDB($result);'."\n";
        $getWhereOrderByDescFromDB.= "\t\t".'return $this->collection;'."\n";
        $getWhereOrderByDescFromDB.= "\t}\n";

        $addToCollectionFromDB = "\t".'private function addToCollectionFromDB($array){'."\n";
        $addToCollectionFromDB.= "\t\t".'if(is_object($array)){'."\n";
        $addToCollectionFromDB.= "\t\t\t".'$inst'.$name.' = new '.MODULENAME.'_'.$name.'();'."\n";
        $addToCollectionFromDB.= "\t\t\t".'$inst'.$name.'->set(';
        foreach($columns as $key=>$cols){
            $addToCollectionFromDB.= '$array->'.$cols['Field'];
            if($key != sizeof($columns)-1)
                $addToCollectionFromDB.=', ';
        }
        $addToCollectionFromDB.= ');'."\n";
        if($nameId == null){
            $addToCollectionFromDB.= "\t\t\t".'$this->collection[sizeof($this->collection)] = $inst'.$name.';'."\n";
        }else{
            $addToCollectionFromDB.= "\t\t\t".'$this->collection[$array->'.$nameId.'] = $inst'.$name.';'."\n";
        }
        $addToCollectionFromDB.= "\t\t".'}else'."\n";
        $addToCollectionFromDB.= "\t\t".'foreach($array as $'.$name.'){'."\n";
        $addToCollectionFromDB.= "\t\t\t".'$inst'.$name.' = new '.MODULENAME.'_'.$name.'();'."\n";
        $addToCollectionFromDB.= "\t\t\t".'$inst'.$name.'->set('."\n";
        foreach($columns as $key=>$cols){
            $addToCollectionFromDB.= "\t\t\t\t".'$'.$name.'->'.$cols['Field'];
            if($key != sizeof($columns)-1)
                $addToCollectionFromDB.=',';
            $addToCollectionFromDB.= "\n";
        }
        $addToCollectionFromDB.= "\t\t\t".');'."\n";
        if($nameId == null){
            $addToCollectionFromDB.= "\t\t\t".'$this->collection[sizeof($this->collection)] = $inst'.$name.';'."\n";
        }else{
            $addToCollectionFromDB.= "\t\t\t".'$this->collection[$'.$name.'->'.$nameId.'] = $inst'.$name.';'."\n";
        }
        $addToCollectionFromDB.= "\t\t}\n";
        $addToCollectionFromDB.= "\t}\n";


        $destructor = "\t".'/**'."\n";
        $destructor.= "\t".'*   Destructor'."\n";
        $destructor.= "\t".'*'."\n";
        $destructor.= "\t".'* <p> Destroy instance of class </p>'."\n";
        $destructor.= "\t".'*'."\n";
        $destructor.= "\t".'* @name '.MODULENAME.'_c'.$name.'::__destruct()'."\n";
        $destructor.= "\t".'* @return void'."\n";
        $destructor.= "\t".'**/'."\n";
        $destructor.= "\t".'public function __destruct() {'."\n";
        $destructor.= "\t\t".'unset($this);'."\n";
        $destructor.= "\t}\n";

        $class.= $titleproprieties."\n\n";
        $class.= $prorieties."\n";
        $class.= $titlemethods."\n\n";
        $class.= $constructor."\n";
        $class.= $set."\n";
        $class.= $get."\n";
        $class.= $getAllFromDB."\n";
        $class.= $getByLimitFromDB."\n";
        $class.= $getAllDescFromDB."\n";
        $class.= $getByLimitDescFromDB."\n";
        $class.= $getAllOrderByFromDB."\n";
        $class.= $getByLimitOrderByFromDB."\n";
        $class.= $getAllOrderByDescFromDB."\n";
        $class.= $getByLimitOrderByDescFromDB."\n";
        $class.= $getAllWhereFromDB."\n";
        $class.= $getWhereOrderByFromDB."\n";
        $class.= $getWhereOrderByDescFromDB."\n";
        $class.= $addToCollectionFromDB."\n";
        $class.= $destructor."\n";

        $class.= "}\n\n";
        $class.= '?>';

        return $class;
    }


    $tables = $db->select('SHOW TABLES',1);
    foreach($tables as $table)
    {
        $name = $table[0];
        $columns = $db->select('SHOW COLUMNS FROM '.$name,2);
        //$nbr = mysql_num_rows($rep );
        $cols = array();
        $i = 0;
        
        if(is_array($columns[0])){
            foreach($columns as $column){
                $cols[$i] = $column;
                $i++;
            }
        }else
            $cols[0] = $columns;

        $ClassFile = fopen('../'.MODULE_PRINCIPAL_PATH.MODULENAME.'.'.$name.'.member.php', 'w+');
        fwrite($ClassFile, CreateMemberClass($name,$cols));
        fclose($ClassFile);

        $CollectionFile = fopen('../'.MODULE_PRINCIPAL_PATH.MODULENAME.'.c'.$name.'.collection.php', 'w+');
        fwrite($CollectionFile, CreateCollectionClass($name,$cols));
        fclose($CollectionFile);
        print_r( CreateCollectionClass($name,$cols));
    }

 ?>