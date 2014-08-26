<?php

namespace core;


/** 
 * Implemets methods set for PHP session.
 * 
 * @author Denis Udovenko
 * @version 1.0.4
 */
class Session
{
    
    /**
     * var {Array} Current session metatdata.
     */
    private $meta = '__metadata__';
   
    
    /**
     * Cretes a new Session instance.
     * 
     * @static
     * @access public
     * @return {Session} New Session instance
     */
    public static function forge()
    {
        return new static();
    }// _forge      
    
    
    /**
     * Public constructor.
     * 
     * @access public
     */
    public function __construct()
    {
        $this->start();
    }// __construct
    

    /**
     * Checks if session is aleady started. If not - sets up cookies parameters
     * and starts session. Then inits metadata.
     * 
     * @access public
     */
    public function start()
    {
        if(session_id() == '') 
        {
            // Set cookies for year:
            session_set_cookie_params(60 * 60 * 12 * 365);
            session_start();
        }// if
        
        isset($_SESSION[$this->meta]) || $this->init();
    }// _start
  
  
    /**
     * Destroys the session with setting obsolete cookie.
     * 
     * @access public
     */
    public function destroy()
    {
        $_SESSION = array();
        
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );

        session_destroy();
    }// destroy

    
    /**
     * Gets value from session.
     * 
     * @access public
     * @param {String} $name Needed value key
     * @param {String} $default Default value if nothing got
     * @return {String | null} Found value or default
     */
    public function get($name, $default = null)
    {
        return isset($_SESSION[$name]) ? $_SESSION[$name] : $default;
    }// get

    
    /**
     * Sets value in session.
     * 
     * @access public
     * @param {String} $name Value key
     * @param {String} $value Value itself   
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
        return $this;
    }// set
    
    
    /**
     * Removes vaule form session.
     * 
     * @access public
     * @param {String} $name Key for value to remove
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }// remove

    
    /**
     * Initializes session metadata.
     * 
     * @access public
     * @return {Boolean} Success flag
     */
    private function init()
    {
        $_SESSION[$this->meta] = array(
            'ip'       => $_SERVER['REMOTE_ADDR'],
            'name'     => session_name(),
            'created'  => $_SERVER['REQUEST_TIME'],
            'activity' => $_SERVER['REQUEST_TIME'],

        );// array
        
        return true;
    }// init
}// Session
