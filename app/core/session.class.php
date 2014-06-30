<?php

namespace core;


/** 
 * 
 */
class Session
{
    private $meta = '__metadata__';
   
    
    /**
     *
     */
    public static function forge()
    {
        return new static();
    }// _forge      
    
    
    /**
     *
     * 
     */
    public function __construct()
    {
        
        $this->start();
    }// __construct
    

    /**
     *
     * 
     * 
     */
    public function start()
    {
        if(session_id() == '') 
        {
            session_set_cookie_params(60 * 60 * 12 * 365);
            session_start();
        }// if
        
        isset($_SESSION[$this->meta]) || $this->init();
    }// _start
    

    /**
     * write session data to store and close the session.
     */
    /*public function commit()
    {
        session_commit();
    }*/

    
    public function destroy()
    {
        $_SESSION = array();
        
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );

        session_destroy();
    }

    
    public function get($name, $default = NULL)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }

    
    /**
     *
     * 
     * @param type $name
     * @param type $value    
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
        return $this;
    }// set
    
    
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }
    
    
    /**
     * @return string
     */
    public function getName()
    {
        return session_name();
    }

    
    private function init()
    {
        $_SESSION[$this->meta] = array(
            'ip'       => $_SERVER['REMOTE_ADDR'],
            'name'     => session_name(),
            'created'  => $_SERVER['REQUEST_TIME'],
            'activity' => $_SERVER['REQUEST_TIME'],

        );
        
        return true;
    }
    
}// Session
