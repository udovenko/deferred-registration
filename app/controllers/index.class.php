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
        echo \core\View::forge("index")->setData(array("data" => "zyyyy"))->render();
    }// get
}// Index
