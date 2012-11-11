<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class hnk_Controller{

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     * @var (String)
     * @desc name of caller;
     */
    public $datas = array();

    /**
     * @var (String)
     * @desc name of caller;
     */
    protected $name = null;

    /**
     * @var (String)
     * @desc name of caller;
     */
    private $views = array();

    /**
     * @var (String)
     * @desc name of caller;
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
     *
     * <p> construct html page to call template </p>
     *
     * @name hnk_Controller::show()
     **/
    protected function show($context=array(),$tpl_name='default'){
        $this->template->set($context);

        $this->template->set('contents',$this->views);

        $this->template->toHtml($this);
    }

    /**
     *   set_view
     *
     * <p>Set a news view to views</p>
     *
     * @name hnk_Controller::set_view()
     **/
    protected function set_view($name='home',$data = array()){

        if(is_string($name))
            $name = ($name[0] == '/')?$name:'/'.$name;
        else return false;

        if(is_array($data)){
            $this->datas[$name] = $data;
        }

        if(file_exists(SITE_VIEWS.$name.HANAKO_EXT_PHP)){
            $this->views[$name] = SITE_VIEWS.$name.HANAKO_EXT_PHP;
        }else return false;

        return true;
    }

    /**
     *   get_view
     *
     * <p>Set a news view to views</p>
     *
     * @name hnk_Controller::get_view()
     **/
    protected function get_view($name='home'){
        return (isset($this->views[$name]))? $this->views[$name]:false;
    }
}
