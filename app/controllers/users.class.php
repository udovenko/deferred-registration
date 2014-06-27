<?php

namespace controllers;


/** 
 * Controller for requests related with users.
 * 
 * @author Denis Udovenko
 * @version 1.0.1
 */
class Users
{
    
    /**
     * Renders registration form.
     */
    public function add()
    {
        $content = \core\View::forge("registration")->render();
        return \core\View::forge("layout")->setData(array("content" => $content))->render();
    }// add
    
    
    /**
     *
     */
    public function confirm()
    {
        $data = \core\Request::forge()->getData();
        echo $data["email"];
    }// confirm
}// Users
