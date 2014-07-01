<?php

namespace controllers;


/** 
 * Session resource controller. Responsible for logging user in/out.
 * 
 * @author Denis Udovenko
 * @version 1.0.3
 */
class Sessions extends Common
{
    
    /**
     * Handles authentication form submits. Cretes new session if user submited
     * valid data or renders form again with error message.
     * 
     * @access public
     * @return {String} Rendered form or executes redirect response
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
     * Logout method. Destroys current session and redirects to index page. 
     * 
     * @access public
     */
    public function destroy()
    {
        \core\Session::forge()->destroy();
        \core\Response::redirect("/");
    }// destroy
}// Session
