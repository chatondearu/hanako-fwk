<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Users extends hnk_Model {

    public $type = '';

	function Users() {

		parent::__construct('id','users','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
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

        $this->type = new User_types();
	}
}