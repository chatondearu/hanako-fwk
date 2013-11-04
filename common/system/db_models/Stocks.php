<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Stocks extends hnk_Model {
	function Stocks() {

		parent::__construct('id','stocks','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['number'] = ''; //int(11)
		$this->rs['product_id'] = ''; //int(11)
		$this->rs['update_to'] = ''; //datetime
		$this->rs['created_to'] = ''; //datetime
	}
}