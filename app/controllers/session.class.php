<?php

namespace controllers;


/** 
 * To change this license header, choose License Headers in Project Properties.
 */
class Session extends Common
{
    
    
    /**
     *
     * 
     */
    public function create()
    {
        $formData = \core\Request::forge()->getData();
        $errors = array();

        if (!empty($formData))
        {
            $users = \models\User::findBy(array(
                "email" => $formData["email"],
                "password" => \models\User::encryptPassword($formData["password"])
            ));
                        
            if (!empty($users))
            {
                $this->_user = $users[0];
                \core\Session::forge()->set(static::SESSION_USER_ID_KEY, $this->_user->getId());
                \core\Response::redirect("/users/show");
            } else {
                
                $this->_user = \models\User::forge($formData["email"]);
                $errors[] = "Invaid email or/and password";
            }// else
            
        } else {
            
            $this->_user = \models\User::forge();
        }// else
        
        $content = \core\View::forge("authentication")->setData(array("user" => $this->_user, "errors" => $errors))->render();
        return $this->_renderLayout($content);
    }// create
    
    
    /**
     *
     * 
     */
    public function destroy()
    {
        \core\Session::forge()->destroy();
        \core\Response::redirect("/");
    }// destroy
}// Session
