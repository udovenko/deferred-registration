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
        $content = \core\View::forge("index")->render();
        return $this->_renderLayout($content);
    }// get
}// Index
