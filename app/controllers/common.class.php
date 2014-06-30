<?php

namespace controllers;


/**
 * 
 */
class Common
{
    const SESSION_USER_ID_KEY = "user_id";
    
    protected $_user = null;
    
    
    /**
     *
     * 
     */
    protected function _renderLayout($content)
    {
        $this->_user || $this->_setCurrentUser();
        return \core\View::forge("layout")->setData(array("content" => $content, "user" => $this->_user))->render();
    }// renderLayout
    
    
    /**
     *
     * 
     * 
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

