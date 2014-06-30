<?php

namespace controllers;


/** 
 * Index page controller.
 * 
 * @author denis Udovenko
 * @version 1.0.1
 */
class Index extends Common
{
    
    const SESSION_USER_ID_KEY = "user_id";
    
    
    /**
     * Renders index page.
     */
    public function get()
    {
        $content = \core\View::forge("index")->render();
        return $this->_renderLayout($content);
    }// get
}// Index
