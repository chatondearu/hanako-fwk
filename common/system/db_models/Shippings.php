<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Shippings extends hnk_Model {
	function Shippings() {

		parent::__construct('id','shippings','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['value'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['description'] = ''; //varchar(500)
		$this->rs['country'] = ''; //varchar(500)
		$this->rs['carrier_id'] = ''; //int(11)
	}
}