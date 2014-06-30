<?php

namespace controllers;


/** 
 * Controller for requests related with users.
 * 
 * @author Denis Udovenko
 * @version 1.0.3
 */
class Users extends Common
{
    
    const SESSION_REGISTRATION_TOKEN_KEY = "registration_token";
    
    
    /**
     * Renders registration form.
     * 
     * @access public
     * @return {String | Response} Rendered layout with registration form or response with redirect
     */
    public function create()
    {
        // If there is aready logged in user, redirect him away:
        $this->_setCurrentUser();
        if (isset($this->_user) && !$this->_user->isNew())  \core\Response::redirect("/");
        
        // Getting form data if it was alredy sent:
        $formData = \core\Request::forge()->getData();
        $errors = array();
        
        if (!empty($formData))
        {
            $this->_user = \models\User::forge($formData["email"], $formData["name"]);
            
            // If validation is passed, sending registration email, else just getting validation errors:
            if ($this->_user->validate())
            {    
                $password = \models\User::generatePassword();
                $registrationToken = \models\User::generateRegistrationToken();
                \core\Session::forge()->set(static::SESSION_REGISTRATION_TOKEN_KEY, $registrationToken);
          
                $this->_sendRegistrationMail($this->_user, $password, $registrationToken);
            } else {
                
                $errors = $this->_user->getErrors();
            }// else
            
        } else { // Creating an empty new user without validation:
            
            $this->_user = \models\User::forge();
        }// else

        // Rendering page layout with registration form:
        $content = \core\View::forge("registration")->setData(array("user" => $this->_user))->render();
        return $this->_renderLayout($content);
    }// add
    
    
    /**
     * If current user is logged in, renders user profile. Else redirect to 
     * index page. 
     * 
     * @access public
     * @return {String | Response} Rendered profile page or redirect response
     */
    public function show()
    {
        $this->_setCurrentUser();
        
        // Redirect to index page, if logged user not found:
        if (!isset($this->_user) || $this->_user->isNew()) \core\Response::redirect("/");
        
        $content = \core\View::forge("profile")->setData(array("user" => $this->_user))->render();
        return $this->_renderLayout($content);
    }// show
    
      
    /**
     * Renders information message about registration e-main, if there is no 
     * current user session. Else redirects to index page.
     * 
     * @access public
     * @return {String | Response} Rendered layout with information message or redirect response
     */
    public function reginfo()
    {
        $this->_setCurrentUser();
        
        // Redirect to index page, if user already registered and logged in:
        if (isset($this->_user) && !$this->_user->isNew()) \core\Response::redirect("/");
        
        $content = \core\View::forge("info")->render();
        return $this->_renderLayout($content);
    }// reginfo
    
    
    /**
     * Accepts registration confirmation request by registration token and 
     * creates user. If token or any other uses info is invalid, renders error
     * page.
     * 
     * @access public
     * @return {Response | String} Responce with redirect or rendered error page
     */
    public function confirm()
    {
        $data = \core\Request::forge()->getData();
        $token = $data['token'];
        $email = $data['email'];
        $name = $data['name'];
        $password = $data['password'];
        
        // If registration link is invalid:
        if ($token !== \core\Session::forge()->get("registration_token")
            || !isset($email) || !isset($name) || !isset($password))
        {
            $content = \core\View::forge("error")->render();
            return \core\View::forge("layout")->setData(array("content" => $content))->render();
        }// if 
        
        // If all checks are passed, create user and start new session with users id:
        $user = new \models\User($email, $name);
        $user->encryptAndSetPassword($password);
        $user->save();
        $session = \core\Session::forge();
        $session->remove(static::SESSION_REGISTRATION_TOKEN_KEY);
        $session->set(static::SESSION_USER_ID_KEY, $user->getId());
        
        // Redirect user to profile page:
        \core\Response::redirect("show");
    }// _confirm
    
    
    /**
     * Sends registration mail and redirects user to info page.
     * 
     * @access private
     * @param {User} $user User instance
     * @return {Responce} Responce with redirect to info page
     */
    private function _sendRegistrationMail($user, $password, $registrationToken)
    {
        $link = \core\Url::getBase() . "/users/confirm?token=" . $registrationToken
            . "&email=" . $user->getEmail() . "&name=" . $user->getName() 
            . "&password=" . $password;
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "From: Testpage\r\n";
        $headers .= "Content-type: text/html; charset=\"UTF-8\"\r\n";
        $message = \core\View::forge("mail")->setData(
            array(
                "user"     => $user, 
                "password" => $password, 
                "link"     => $link
            ))->render();
        mail($user->getEmail(), "Your registration on test page", $message, $headers);
        
        \core\Response::redirect("reginfo");
    }// _sendRegistrationMail
}// Users
