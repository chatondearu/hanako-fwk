<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');class Control_home extends hnk_Controller{    /**     * Constructor     */    public function __construct(){        parent::__construct();    }    public function init(){        global $hnk_db;        //var_dump($hnk_db->select('SHOW TABLES',2));        //dynamic data.        $data = array('toto'=>'toto2');        $this->set_view('global/header');        $this->set_view('index',$data);        $this->show(array(            'title'=>'Home',            'description'=>'Je suis la home de Hanako'        ));    }    public function testbdd(){        //dynamic data.        $data = array('toto'=>'toto');        $this->set_view('index',$data);        $this->show(array(            'title'=>'Home',            'description'=>'Je suis la home de Hanako'        ));    }}