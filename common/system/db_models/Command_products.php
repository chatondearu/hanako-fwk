<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Command_products extends hnk_Model {
	function Command_products() {

		parent::__construct('id','command_products','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['id_command'] = ''; //int(11)
		$this->rs['id_product'] = ''; //int(11)
		$this->rs['quantity'] = ''; //int(11)
		$this->rs['ht'] = ''; //int(11)
		$this->rs['ttc'] = ''; //int(11)
	}
}