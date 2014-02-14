<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class hnk_Template {

    /*~*~*~*~*~*~*~*~*~*~*/
    /*  1. proprieties   */
    /*~*~*~*~*~*~*~*~*~*~*/

    /**
     * @var (Array)
     * @desc NC;
     */
    private $ref_compo = array();

    /**
     * @var (Object)
     * @desc description to show in template.
     */
    public $content = false;

    /**
     * @var (Object)
     * @desc description to show in template.
     */
    private $controller;

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
     * page information
     * @var array
     */
    protected $info = array();


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

        //set default composer;
        $this->ref_compo = array(
            'path' => array(
                'favicon'=>SRC_HTTP_FAVICON.'/www'
            ),
            'styles' => array(),
            'scripts' => array(
                'top' => array(),
                'bottom' => array()
            )
        );

        //set default infos/tags
        $this->info = array(
            'schema' => '',
            'title' => '',
            'name' => '',
            'description' => '',
            'image' => '',
            'keywords' => '',
        );

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
    public function toHtml($controller){
        $this->controller = $controller;
        $hnk_tpl_component = array();

        //récupération de la config du template
        $path = SITE_TEMPLATE.'/'.$this->ref_tpl.'/src/'.$this->ref_config.HANAKO_EXT_PHP;

        //merge default composer and composer of skin
        if(file_exists($path)){
            require_once $path;
            $this->ref_compo = array_replace_recursive($this -> ref_compo, $hnk_tpl_component);
        }

        // Module Content
        // resolve content from keys
        if($this->content){
            foreach($this->controller->views as $key=>$name){
                $key = ($key[0] == '/')? substr($key,0,strlen($key)):$key;
                $this->content->get($key);
            }
        }

        //get template
        $path = SITE_TEMPLATE.'/'.$this->ref_tpl.'/html'.HANAKO_EXT_PHP;
        if(file_exists($path)){
            require_once $path;
        }
    }

    private function add_view($name = '', $datas = array(), $path = '', $is_fromController = false){

        if(!$is_fromController){

            if(is_string($name))
                $name = ($name[0] == '/')?$name:'/'.$name;
            else return false;

            if(file_exists(SITE_VIEWS.$name.HANAKO_EXT_PHP)){
                $path = SITE_VIEWS.$name.HANAKO_EXT_PHP;
            } else {
                echo 'no template '.$name;
                return false;
            }
        }

        foreach($datas as $dataName=>$value){
            ${$dataName}=$value;
        }
        //contents exist we load all
        //include content
        $name = str_replace('/',' ',$name);

        echo '<!-- START '.$name.' -->';
        require $path;
        echo '<!-- END '.$name.' -->';
        return true;
    }

    private function make_views(){
        foreach($this->controller->views as $name=>$obj){
            $this->add_view($name, $obj['datas'], $obj['path'], true);
        }
    }

    private function get_compo($name = ''){
        if(is_string($name)){
            $compo = $this->ref_compo;
            $way = (stripos($name,'.'))? preg_split('/\./',$name):array($name);

            foreach($way as $val){
                if(array_key_exists($val,$compo)){
                    if(is_string($compo[$val])){
                        $compo = $compo[$val];
                        break;
                    }elseif(is_array($compo[$val]))
                        $compo = $compo[$val];
                }
            }

            if(is_string($compo))
                return $compo;
            elseif(is_array($compo) ){
                return join("\n",$compo);
            }
        }
        return false;
    }

    private function get_info($name = ''){
        if(is_string($name)){
            return $this->info[$name];
        }
        return false;
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

}
