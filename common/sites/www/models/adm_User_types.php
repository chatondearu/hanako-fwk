<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class adm_User_types extends User_types {

    public function getNbrUsers ($type) {
        $users = new Users();
        return count( $users->retrieve_many('type_id = '.$type->rs['id']) );
    }

    public function _get($id) {
        //$args[0] correspond id of User_types
        if(is_numeric($id)){
            $this->retrieve(intval($id));
            if($this->exists()){
                return $this->rs;
            }else{
                return 'no exist';
            }
        }else{
            return 'no id';
        }
    }

    public function _list() {
        $data = array();
        foreach($this->retrieve_many() as $type){
            array_push($data , $type->rs);
            $data[count($data)-1]['total'] = $this->getNbrUsers($type);
        }
        return $data;
    }

    public function _update() {
    }

    public function _delete() {
    }

    public function _create() {
        $form = new form_Core();
        global $form;

        $form->rule('libelle','libelle','text',true,250,4);
        $form->rule('constant','constant','simpleText',true,3,2);

        if($form->start()){

            if($form->isCheck){

                $type = new User_types();

                $type->merge(array(
                    'libelle'=>$form->value('libelle'),
                    'constant'=>$form->value('constant')
                ));

                $type = $type->create();

                echo '{"type":"type","state":"valide","data":'.json_encode($type->rs).'}';

            }else{
                echo '{"type":"type","state":"no","data":'.json_encode($form->errors()).'}';
            }
        }else{
            echo '{"type":"type","state":"no","data":'.json_encode($form->errors()).'}';
        }
    }

}