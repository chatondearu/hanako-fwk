<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Tags extends hnk_Model {
	function Tags() {

		parent::__construct('id','tags','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['name'] = ''; //varchar(45)
		$this->rs['const'] = ''; //varchar(45)
		$this->rs['category_id'] = ''; //int(11)
	}
}