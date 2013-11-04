<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Contacts extends hnk_Model {
	function Contacts() {

		parent::__construct('id','contacts','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['adresse'] = ''; //varchar(250)
		$this->rs['zip_code'] = ''; //varchar(5)
		$this->rs['city'] = ''; //varchar(45)
		$this->rs['department'] = ''; //int(2)
		$this->rs['country'] = ''; //varchar(250)
		$this->rs['phone_landline'] = ''; //int(10)
		$this->rs['phone_port'] = ''; //int(10)
		$this->rs['type_id'] = ''; //int(11)
	}
}