<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class adm_Users extends Users {

	/*  $this->rs['id'] = ''; //int(11)
		$this->rs['username'] = ''; //varchar(25)
		$this->rs['password'] = ''; //varchar(250)
		$this->rs['media_id'] = ''; //int(11)
		$this->rs['mail'] = ''; //varchar(250)
		$this->rs['type_id'] = ''; //int(11)
		$this->rs['name'] = ''; //varchar(45)
		$this->rs['firstname'] = ''; //varchar(45)
		$this->rs['birthday'] = ''; //date
		$this->rs['last_connection'] = ''; //datetime
		$this->rs['inscription'] = ''; //datetime
		$this->rs['description'] = ''; //text

        $this->type = new User_types();  */

    public function _get($id) {
        //$args[0] correspond id of User
        if(is_numeric($id)){
            $this->retrieve(intval($id));
            if($this->exists()){

                $this->rs['birthday'] = strtotime($this->rs['birthday'])*1000;
                $this->rs['last_connection'] = strtotime($this->rs['last_connection'])*1000;
                $this->rs['inscription'] = strtotime($this->rs['inscription'])*1000;

                $this->type->retrieve($this->type_id);
                $this->rs['type'] = $this->type->rs;

                $this->rs['contacts'] = array();

                $uc = new Users_contacts();
                $user_uc = $uc->retrieve_many('user_id = '.$this->id);
                foreach($user_uc as $c_id){
                    $contact = new Contacts();
                    $contact->retrieve($c_id->contact_id);
                    if($contact->exists()){
                        array_push($this->rs['contacts'], $contact->rs);
                    }
                }

                return $this->rs;
            }else{
                return 'no exist';
            }
        }else{
            return 'no id';
        }
    }

    public function _list() {
        /* service model: list_users
          ['users',[
                [id,'username','mail','url_img',type_id], ...
            ]
          ]
        */
        $data = array();
        //for($i=0;$i<=89;$i++){
        foreach($this->retrieve_many() as $user){
            $user->type->retrieve($user->type_id);
            $user->rs['type'] = $user->type->rs;

            array_push($data, $user->rs);
        }
        //}
        return $data;
    }

    public function _update() {
        //$form = new form_Core();
        global $form;

        $form->rule('id','id','numeric',true);
        $form->rule('username','Username','alphanum',true,25,3);
        $form->rule('mail','Mail','mail',true,250,6);
        $form->rule('name','Name','simpleText',true,45,3);
        $form->rule('firstname','Firstname','simpleText',true,45,3);

        $form->rule('type','Type','numeric',true);

        $form->rule('birthday','Birthday','birthday',false,10,0,13,120,'dd-mm-yyyy');
        $form->rule('description','description','text',false,'500');

        if($form->start()){

            if($form->isCheck){

                $user = new Users();
                $user->retrieve($form->value('id'));

                list($dd,$mm,$yy) = @explode("/",$form->value('birthday'));
                $stamp = strtotime("$mm/$dd/$yy");
                $birthday = date('Y-m-d', $stamp);

                $user->merge(array(
                    'username'=>$form->value('username'),
                    'mail'=>$form->value('mail'),
                    'type_id'=>$form->value('type'),
                    'name'=>$form->value('name'),
                    'firstname'=>$form->value('firstname'),
                    'birthday'=>$birthday,
                    'description'=>$form->value('description'),
                ));

                $user->update();

                echo '{"type":"user","state":"valide","data":'.json_encode($user->rs).'}';

            }else{
                echo '{"type":"user","state":"no","data":'.json_encode($form->errors()).'}';
            }
        }else{
            echo '{"type":"user","state":"no","data":'.json_encode($form->errors()).'}';
        }
    }

    public function _delete() {

    }

    public function _create() {
        //$form = new form_Core();
        global $form;

        $form->rule('id','id','numeric',false);
        $form->rule('username','Username','alphanum',true,25,3);
        $form->rule('password','Password','password',true,250,6);
        $form->rule('mail','Mail','mail',true,250,6);
        $form->rule('name','Name','simpleText',true,45,3);
        $form->rule('firstname','Firstname','simpleText',true,45,3);

        $form->rule('type','Type','numeric',true);

        $form->rule('birthday','Birthday','birthday',false,10,0,13,120,'dd-mm-yyyy');
        $form->rule('description','description','text',false,'500');

        if($form->start()){

            if($form->value('id') !== '') {
                echo('update');
            } else {
                echo('add');
            }

            //check if type exist;
            $type_user = new User_types();
            $type_user->retrieve_one('id = ?',$form->value('type'));
            if(!$type_user->exists())
                $form->set_error('type','Type non trouvé...');

            //check if mail exist;
            $user = new Users();
            $user->retrieve_one('mail = ?',$form->value('mail'));
            if($user->exists())
                $form->set_error('mail','Utilisateur trouvé...');

            //check if username exist;
            $user = new Users();
            $user->retrieve_one('username = ?', $form->value('username'));
            if($user->exists())
                $form->set_error('username','Utilisateur trouvé...');


            if($form->isCheck){

                $user = new Users();

                list($dd,$mm,$yy) = @explode("/",$form->value('birthday'));
                $stamp = strtotime("$mm/$dd/$yy");
                $birthday = date('Y-m-d', $stamp);

                $user->merge(array(
                    'username'=>$form->value('username'),
                    'password'=>md5($form->value('password')),
                    'mail'=>$form->value('mail'),
                    'type_id'=>$form->value('type'),
                    'name'=>$form->value('name'),
                    'firstname'=>$form->value('firstname'),
                    'birthday'=>$birthday,
                    'description'=>$form->value('description'),
                ));

                $user = $user->create();

                echo '{"type":"user","state":"valide","data":'.json_encode($user->rs).'}';

            }else{
                echo '{"type":"user","state":"no","data":'.json_encode($form->errors()).'}';
            }
        }else{
            echo '{"type":"user","state":"no","data":'.json_encode($form->errors()).'}';
        }
    }
}