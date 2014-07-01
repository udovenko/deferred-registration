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
    
    /**
     * Renders index page.
     * 
     * @access public
     * @return {String} Rendered page
     */
    public function get()
    {
        $this->_setCurrentUser();
        
        $content = \core\View::forge("index")->setData(array("user" => $this->_user))->render();
        return $this->_renderLayout($content);
    }// get
}// Index
