<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Balance_links extends hnk_Model {
	function Balance_links() {

		parent::__construct('id','balance_links','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['balance_id'] = ''; //int(11)
		$this->rs['user_id'] = ''; //int(11)
		$this->rs['user_type_id'] = ''; //int(11)
		$this->rs['product_id'] = ''; //int(11)
		$this->rs['product_type_id'] = ''; //int(11)
		$this->rs['product_family_id'] = ''; //int(11)
	}
}