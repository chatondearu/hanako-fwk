<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Tag_categorys extends hnk_Model {
	function Tag_categorys() {

		parent::__construct('id','tag_categorys','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['label'] = ''; //varchar(45)
		$this->rs['title'] = ''; //varchar(250)
		$this->rs['description'] = ''; //text
		$this->rs['media_id'] = ''; //int(11)
		$this->rs['const'] = ''; //varchar(45)
	}
}