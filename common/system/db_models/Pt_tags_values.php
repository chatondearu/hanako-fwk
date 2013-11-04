<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Pt_tags_values extends hnk_Model {
	function Pt_tags_values() {

		parent::__construct('id','pt_tags_values','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['content'] = ''; //text
		$this->rs['media_id'] = ''; //int(11)
		$this->rs['tag_id'] = ''; //int(11)
		$this->rs['product_id'] = ''; //int(11)
	}
}