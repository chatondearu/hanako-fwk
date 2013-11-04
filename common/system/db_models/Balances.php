<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Balances extends hnk_Model {
	function Balances() {

		parent::__construct('id','balances','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['description'] = ''; //text
		$this->rs['discount'] = ''; //int(11)
		$this->rs['is_percent'] = ''; //int(1)
		$this->rs['is_active'] = ''; //int(1)
		$this->rs['created_to'] = ''; //datetime
		$this->rs['started_to'] = ''; //datetime
		$this->rs['ended_to'] = ''; //datetime
	}
}