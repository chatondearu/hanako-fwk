<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Product_tags extends hnk_Model {
	function Product_tags() {

		parent::__construct('id','product_tags','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(250)
		$this->rs['description'] = ''; //text
		$this->rs['type_id'] = ''; //int(11)
		$this->rs['family_id'] = ''; //int(11)
		$this->rs['media_id'] = ''; //int(11)
	}
}