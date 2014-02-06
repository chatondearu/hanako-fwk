<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

class Posts extends hnk_Model {

    public $type = '';
    public $state = '';
    public $user = '';

	function Posts() {

		parent::__construct('id','posts','hnk_getDB');

		$this->rs['id'] = ''; //int(11)
		$this->rs['title'] = ''; //varchar(250)
		$this->rs['description'] = ''; //text
		$this->rs['media_id'] = ''; //int(11)
		$this->rs['table_contents'] = ''; //text
		$this->rs['content'] = ''; //text
		$this->rs['created_to'] = ''; //datetime
		$this->rs['posted_to'] = ''; //datetime
		$this->rs['updated_to'] = ''; //datetime
		$this->rs['compatibility_support'] = ''; //varchar(10)
		$this->rs['state_id'] = ''; //int(11)
		$this->rs['type_id'] = ''; //int(11)
		$this->rs['user_id'] = ''; //int(11)

        $this->type = new Post_types();
        $this->state = new Post_states();
        $this->user = new Users();
	}
}