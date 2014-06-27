<?php

namespace controllers;


/** 
 * Index page controller.
 * 
 * @author denis Udovenko
 * @version 1.0.1
 */
class Index
{
    
  
    /**
     * Renders index page.
     */
    public function get()
    {
        $content = \core\View::forge("index")->setData(array("data" => "zyyyy"))->render();
        return \core\View::forge("layout")->setData(array("content" => $content))->render();
    }// get
}// Index
