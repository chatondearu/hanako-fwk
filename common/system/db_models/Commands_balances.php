<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Commands_balances extends hnk_Model {
	function Commands_balances() {

		parent::__construct('id','commands_balances','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['command_id'] = ''; //int(11)
		$this->rs['balance_id'] = ''; //int(11)
	}
}