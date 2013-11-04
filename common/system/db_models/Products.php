<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Products extends hnk_Model {
	function Products() {

		parent::__construct('id','products','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(225)
		$this->rs['description'] = ''; //text
		$this->rs['reference'] = ''; //varchar(45)
		$this->rs['type_id'] = ''; //int(11)
		$this->rs['media_id'] = ''; //int(11)
		$this->rs['price'] = ''; //int(11)
		$this->rs['tva'] = ''; //int(3)
		$this->rs['other_taxe'] = ''; //int(3)
		$this->rs['created_to'] = ''; //datetime
		$this->rs['last_modification'] = ''; //datetime
		$this->rs['state_id'] = ''; //int(11)
		$this->rs['is_promote'] = ''; //int(1)
		$this->rs['is_package'] = ''; //int(1)
	}
}