<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Tags_posts extends hnk_Model {
	function Tags_posts() {

		parent::__construct('id','tags_posts','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['tag_id'] = ''; //int(11)
		$this->rs['post_id'] = ''; //int(11)
	}
}