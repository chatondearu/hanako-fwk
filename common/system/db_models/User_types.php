<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class User_types extends hnk_Model {
	function User_types() {

		parent::__construct('id','user_types','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['libelle'] = ''; //varchar(45)
		$this->rs['constant'] = ''; //varchar(2)
	}
}