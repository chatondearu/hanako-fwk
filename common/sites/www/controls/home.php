<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');class Control_home extends hnk_Controller{    private $info;    /**     * Constructor     */    public function __construct(){        parent::__construct();            $this->info = array(                'title'=>'Hanako '.HANAKO_VERSION,                'description'=>"",                'schema' => 'project',                'name' => 'Hanako '.HANAKO_VERSION,                'keywords' => '',                'image' => ''            );    }    public function init(){        //dynamic data.        $data = array('toto'=>'toto2');        $this->set_view('global/header');        $this->set_view('index',$data);        $this->show($this->info);    }}