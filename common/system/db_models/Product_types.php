<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Product_types extends hnk_Model {
	function Product_types() {

		parent::__construct('id','product_types','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['const'] = ''; //varchar(2)
		$this->rs['family_id'] = ''; //int(11)
	}
}