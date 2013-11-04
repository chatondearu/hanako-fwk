<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Command_states extends hnk_Model {
	function Command_states() {

		parent::__construct('id','command_states','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['description'] = ''; //text
		$this->rs['const'] = ''; //varchar(45)
	}
}