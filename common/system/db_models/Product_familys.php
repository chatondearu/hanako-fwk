<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Product_familys extends hnk_Model {
	function Product_familys() {

		parent::__construct('id','product_familys','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(250)
		$this->rs['description'] = ''; //text
	}
}