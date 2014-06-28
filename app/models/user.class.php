<?php

namespace models;


/** 
 * User model.
 * 
 * @author Denis Udovenko
 * @version 1.0.3
 */
class User
{
    
    private $_email;
    private $_name;
    private $_errors; 
    
    
    /**
     * Returns new User instance.
     * 
     * @static
     * @access public
     * @param {String} $email Users e-mail
     * @param {String} $name User name
     * @return {User} New User instance
     */
    public static function forge($email = null, $name = null)
    {
        return new static($email, $name);
    }// forge
    
    
    /**
     * Public constructor.
     * 
     * @access public
     * @param {String} $email Users e-mail
     * @param {String} $name User name
     */
    public function __construct($email = null, $name = null)
    {
        $this->_email = $email;
        $this->_name = $name;
    }// __construct
    
    
    /**
     * Validates current current instance fields. 
     */
    public function validate()
    {
        // Reseting errors array:
        $this->_errors = array();
        
        
        // Validation rules for e-mail:
        if (!isset($this->_email) || empty(trim($this->_email)))
            $this->_errors[] = "email is empty";
        
        if (!preg_match("/\A[\w+\-.]+@[a-z\d\-]+(\.[a-z]+)*\.[a-z]+\z/i", $this->_email)) 
            $this->_errors[] = "email has invalid format";
        
        
        // Validation rules for name:
        if (!isset($this->_name) || empty(trim($this->_name)))
            $this->_errors[] = "name is empty";

        if (strlen($this->_name) > 20) $this->_errors[] = "name is too long (only 20 characters is allowed)";
        
        
        return empty($this->_errors); 
    }// validate
    
    
    /**
     * Returns current user e-mail.
     * 
     * @access public
     * @return {String} Current user e-mail
     */
    public function getEmail()
    {
        return $this->_email;        
    }// getEmail
    
    
    /**
     * Returns current user name.
     * 
     * @access public
     * @return {String} Current user name
     */
    public function getName()
    {
        return $this->_name;
    }// getName
    
    
    /**
     * Returns current user validation errors array. Call "validate" method
     * before otherwise array will be empty. 
     * 
     * @access public
     * @return {Array} Current user validation errors
     */
    public function getErrors()
    {
        return $this->_errors;
    }// getErrors
        
    
    /**
     *
     * 
     */
    public function generateRegistrationToken()
    {
        
        
    }
    
    
    /**
     *
     * 
     */
    public function generatePassword()
    {
        
    }// sendRegistrationMail
}// User
