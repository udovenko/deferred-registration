<?php

namespace controllers;


/** 
 * Controller for requests related with users.
 * 
 * @author Denis Udovenko
 * @version 1.0.3
 */
class Users
{
     
    /**
     * Renders registration form.
     * 
     * @access public
     * @return {String} Rendered layout with registration form
     */
    public function create()
    {
        $formData = \core\Request::forge()->getData();
        $errors = array();
        
        if (!empty($formData))
        {
            $user = \models\User::forge($formData["email"], $formData["name"]);
            
            // If validation is passed, sending registration email, else just getting validation errors:
            if ($user->validate()) $this->_sendRegistrationMail($user);
            else $errors = $user->getErrors();
                   
        } else { // Creating an empty new user without validation:
            
            $user = \models\User::forge();
        }// else

        // Rendering page layout with registration form:
        $content = \core\View::forge("registration")->setData(array("user" => $user))->render();
        return \core\View::forge("layout")->setData(array("content" => $content))->render();
    }// add
    
      
    /**
     * Renders information message about registration e-main.
     * 
     * @access public
     * @return {String} Rendered layout with information message
     */
    public function reginfo()
    {
        $content = \core\View::forge("info")->render();
        return $content;
    }// reginfo
    
    
    /**
     * Sends registration mail and redirects user to info page.
     * 
     * @access private
     * @param {User} $user User instance
     * @return {Responce} Responce with redirect to info page
     */
    private function _sendRegistrationMail($user)
    {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $message = \core\View::forge("mail")->setData(array("user" => $user))->render();
        mail($user->getEmail(), "Your registration on test page", $message, $headers);
        
        \core\Response::redirect("reginfo");
    }//_sendRegistrationMail
}// Users
