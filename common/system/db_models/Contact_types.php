<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Contact_types extends hnk_Model {
	function Contact_types() {

		parent::__construct('id','contact_types','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['const'] = ''; //varchar(2)
	}
}