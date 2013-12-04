<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class hnk_Template {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     * @var (Array)
     * @desc NC;
     */
    public $ref_compo = array();

    /**
     * @var (Object)
     * @desc description to show in template.
     */
    public $content = false;

    /**
     * @var (Object)
     * @desc description to show in template.
     */
    private $caller;


    /**
     * @var (String)
     * @desc NC;
     */
    protected $ref_tpl;
    /**
     * @var (String)
     * @desc NC;
     */
    protected $ref_config;

    /**
     * @var (String)
     * @desc schema of page reference for Google
     */
    protected $schema = null;

    /**
     * @var (String)
     * @desc title to show in template.
     */
    protected $title = null;

    /**
     * @var (String)
     * @desc name to show in template.
     */
    protected $name = null;

    /**
     * @var (String)
     * @desc description to show in template.
     */
    protected $description = null;
    /**
     * @var (String)
     * @desc description to show in template.
     */
    protected $image = null;

    /**
     * @var (String)
     * @desc description to show in template.
     */
    protected $keywords = null;


    /**
     * @var (String)
     * @desc style of Page to show in template.
     */
    protected $style = null;

    /**
     * @var (String)
     * @desc description to show in template.
     */
    protected $contents = array();


    /*~*~*~*~*~*~*~*~*~*~*/
    /*  2. methods       */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     *   Constructor
     *
     * <p> Construct instance of class </p>
     *
     * @name hnk_Template::__construct()
     **/
    public function __construct($ref_tpl='default',$ref_config='default'){
        global $hnk_mods;
        $this->ref_tpl=$ref_tpl;
        $this->ref_config=$ref_config;
        if($hnk_mods->isInit('contents'))
            $this->content = $hnk_mods->get('contents');
    }

    public function set_config($name='default'){
        $this->ref_config=$name;
    }

    public function set_template($name='default'){
        $this->ref_tpl=$name;
    }

    /**
     *
     */
    public function toHtml($caller){
        $this->caller = $caller;

        //récupération de la config du template
        $path = HANAKO_TEMPLATE.'/'.$this->ref_tpl.'/src/'.$this->ref_config.HANAKO_EXT_PHP;
        if(file_exists($path)){
            require_once $path;
            $this->ref_compo = $hnk_tpl_component;
        }

        if($this->content){
            foreach($this->contents as $key=>$name){
                $key = ($key[0] == '/')? substr($key,0,strlen($key)):$key;
                $this->content->get($key);
            }
        }

        //recupèration du template
        $path = HANAKO_TEMPLATE.'/'.$this->ref_tpl.'/html'.HANAKO_EXT_PHP;
        if(file_exists($path)){
            require_once $path;
        }
    }

    /**
     * @name hnk_Template::set()
     * @desc set values of instance
     * |title|name|description|keywords|contents|||||
     *
     * @param $label
     * @param $context
     * @return bool
     */
    public function set($label,$context=null){

        if(is_array($label)){ // array('text'=>'toto')
            foreach($label as $name=>$value){
                $this->set($name,$value);
            } return true;
        }elseif(is_string($label)){
            if(!is_null($context)){
                if(is_array($context)){
                    foreach($context as $name => $path){
                        $this->{$label}[$name] = $path;
                    }return true;
                }elseif(is_string($context)){
                    $this->{$label} = $context;
                    return true;
                }
            }return false;
        }return false;

    }

    public function get($name){
        //look if get contents
        if(is_array($this->{$name}) && sizeof($this->{$name})>0 ){
            foreach($this->{$name} as $key=>$path){
                if(file_exists($path)){ //contents exist we load all
                    //for all content we look for datas
                    foreach($this->caller->datas[$key] as $dataName=>$value){
                        ${$dataName}=$value;
                    }
                    //include content
                    $key = str_replace('/',' ',$key);

                    echo '<!-- START '.$key.' -->';
                    require $path;
                    echo '<!-- END '.$key.' -->';
                }
            }
            return $this->{$name};
        }
        //get others values
        return $this->{$name};
    }

}
