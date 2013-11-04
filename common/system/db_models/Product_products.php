<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Product_products extends hnk_Model {
	function Product_products() {

		parent::__construct('id','product_products','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['product_id'] = ''; //int(11)
		$this->rs['product_bis_id'] = ''; //int(11)
	}
}