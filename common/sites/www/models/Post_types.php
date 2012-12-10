<?php if ( ! defined('HANAKO_SYSTEM')) exit('Accès interdis');

/*

// Post_Types
--- global ---
-> id (int) auto-increm
-> label (text)
-> title (text)
-> description (text) null
-> img (data||url) null
-> const (text)

*/

class Post_types extends hnk_Model {

    function Post_types() {

        parent::__construct('id','post_types','hnk_getDB');

        $this->rs['id'] = '';
        $this->rs['label'] = '';
        $this->rs['title'] = '';
        $this->rs['description'] = '';
        $this->rs['img'] = '';
        $this->rs['const'] = '';

    }

}
