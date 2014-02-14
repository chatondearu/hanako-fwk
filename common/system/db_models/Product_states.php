<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Product_states extends hnk_Model {
	function Product_states() {

		parent::__construct('id','product_states','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['const'] = ''; //varchar(2)
		$this->rs['description'] = ''; //text
		$this->rs['title'] = ''; //varchar(250)
	}
}