<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');


/*

// Posts
--- global ---
-> id (int) auto-increm
-> title (text)
-> description (text) null
-> img (data||url) null
-> table_contents (list/text) null
-> content (html/text)
--- type dependency ---
-> compatibility_support (text/list) null
--- dates ---
-> created_to (date)
-> posted_to (date) null
-> last_modification (date) null
--- links ---
-> state_id (int)
-> type_id (int)
-> user_id (int)

*/

class Posts extends hnk_Model {

    function Posts() {

        parent::__construct('id','posts','hnk_getDB');

        $this->rs['id'] = '';
        $this->rs['title'] = '';
        $this->rs['description'] = '';
        $this->rs['img'] = '';
        $this->rs['table_contents'] = '';
        $this->rs['content'] = '';
        $this->rs['compatibility_support'] = '';
        $this->rs['created_to'] = '';
        $this->rs['posted_to'] = '';
        $this->rs['last_modification'] = '';
        $this->rs['state_id'] = '';
        $this->rs['type_id'] = '';
        $this->rs['user_id'] = '';

    }

}

/*

// Post_States
--- Global ---
-> id (int) auto-increm
-> label (text)
-> title (text) null
-> description (test) null
-> const (text)

// Post_Types
--- global ---
-> id (int) auto-increm
-> label (text)
-> title (text)
-> description (text) null
-> img (data||url) null
-> const (text)

// Posts & Tags
--- global ---
-> id (int) auto-increm
-> tag_id (int)
-> post_id (int)

// Tags
--- global ---
-> id (int) auto-increm
-> name (text)
-> const(text)
-> category_id (int)

// Category_Tags
--- Global ---
-> id (int) auto-increm
-> label (text)
-> title (text)
-> description (text) null
-> img (data||url) null
-> const (text)

*/