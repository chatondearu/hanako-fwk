<?php

function init_ajax_security() {
    if(
        !(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
          strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    ) {
        hnk_show_error(403);
    }
}