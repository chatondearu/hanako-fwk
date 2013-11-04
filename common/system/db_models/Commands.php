<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Commands extends hnk_Model {
	function Commands() {

		parent::__construct('id','commands','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['user_id'] = ''; //int(11)
		$this->rs['fact_contact_id'] = ''; //int(11)
		$this->rs['adress_contact_id'] = ''; //int(11)
		$this->rs['reference'] = ''; //varchar(45)
		$this->rs['shipping_id'] = ''; //int(11)
		$this->rs['comment'] = ''; //varchar(500)
		$this->rs['state_id'] = ''; //int(11)
		$this->rs['total_quantity'] = ''; //int(11)
		$this->rs['total_ht'] = ''; //int(11)
		$this->rs['total_ttc'] = ''; //int(11)
		$this->rs['created_to'] = ''; //datetime
		$this->rs['updated_to'] = ''; //datetime
	}
}