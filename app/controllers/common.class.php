<?php

namespace controllers;


/**
 * Common parent for application controllers. 
 * 
 * @author Denis Udovenko
 * @version 1.0.1
 */
class Common
{
    const SESSION_USER_ID_KEY = "user_id";
    
    protected $_user = null;
    
    
    /**
     * Renders page layout with given content depending on presence of logged 
     * in user.
     * 
     * @access protected
     * @param {String} Rendered page content
     * @return {String} Page layout with given content
     */
    protected function _renderLayout($content)
    {
        $this->_user || $this->_setCurrentUser();
        return \core\View::forge("layout")->setData(array("content" => $content, "user" => $this->_user))->render();
    }// renderLayout
    
    
    /**
     * Checks if session contains current user identifier and sets "_user"
     * field if so.
     * 
     * @access protected
     */
    protected function _setCurrentUser()
    {
        $userId = \core\Session::forge()->get(static::SESSION_USER_ID_KEY);
        
        if (isset($userId))
        {    
            $users = \models\User::findBy(array("id" => $userId));
            $this->_user = $users[0];
        }// if    
    }// _currentUser
}// Common

