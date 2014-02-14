<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

abstract class hnk_Controller{

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     * @var (String)
     * @desc name of caller;
     */
    protected $name = null;

    /**
     * @var (Array)
     * @desc list of views;
     */
    public $views = array();

    /**
     * @var (Object)
     * @desc template;
     */
    private $template;


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name hnk_Controller::__construct()
     **/
    public function __construct(){
        global $hnk_tpl;
        $this->template = $hnk_tpl;
    }

    /**
     *   show
     * <p> construct html page to call template </p>
     * @name hnk_Controller::show()
     **/
    protected function show($info=array()){
        $this->template->set($info);
        $this->template->toHtml($this);
    }

    /**
     *   set_view
     * <p>Set a news view to views</p>
     * @name hnk_Controller::set_view()
     **/
    protected function set_view($name='home',$data = array()){

        if(is_string($name))
            $name = ($name[0] == '/')?$name:'/'.$name;
        else return false;

        if(file_exists(SITE_VIEWS.$name.HANAKO_EXT_PHP)){
            $this->views[$name] = array();
            if(is_array($data)){
                $this->views[$name]['datas'] = $data;
            }else{
                $this->views[$name]['datas'] = false;
            }
            $this->views[$name]['path'] = SITE_VIEWS.$name.HANAKO_EXT_PHP;
        }else return false;

        return true;
    }

    /**
     * set_Template
     */
    protected  function set_Template($name){
        global $hnk_tpl;
        $this->template = new hnk_Template($name);
        $hnk_tpl = $this->template;
    }
}
