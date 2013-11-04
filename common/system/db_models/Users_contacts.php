<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Users_contacts extends hnk_Model {

    public $user;
    public $contact;

	function Users_contacts() {

		parent::__construct('id','users_contacts','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['user_id'] = ''; //int(11)
		$this->rs['contact_id'] = ''; //int(11)
	}

}