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
    
    const REGISTRATION_TOKEN_LENGTH = 18;
    const PASSWORD_MIN_LENGTH       = 6;
    const PASSWORD_MAX_LENGTH       = 10;
    const PASSWORD_SALT             = "N31b!pR4";
    
    private $_email;
    private $_name;
    private $_password;
    private $_token;
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
        $this->_generatePassword();
        $this->_generateRegistrationToken();
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
     *
     * 
     */
    public function getRegistrationToken()
    {
        return $this->_token;        
    }// _getRegistrationToken
    
    
    /**
     * Returns generated password.
     * 
     * @access public
     * @return {String} Current user name
     */
    public function getPassword()
    {
        return $this->_password;
    }// _getPassword
    
    
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
     * Generates registration token.
     * 
     * @access private
     */
    public function _generateRegistrationToken()
    {        
        $this->_token = static::_randomString(static::REGISTRATION_TOKEN_LENGTH);
    }// _generateRegistrationToken
    
    
    /**
     * Generates user password.
     * 
     * @access private
     */
    private function _generatePassword()
    {
        // Initialize a random desired length:
        $length = rand(static::PASSWORD_MIN_LENGTH, static::PASSWORD_MAX_LENGTH);
        $this->_password = static::_randomString($length);
    }// sendRegistrationMail
    
    
    /**
     * Generates random string of given length.
     * 
     * @param {Integer} $length Result string length
     * @return {String} Generated string
     */
    private static function _randomString($length)
    {
        $result = '';
        $charSets = array(
            array(48, 57), // Digits
            array(65, 90), // Capital letters
            array(97, 122) // Lowercase letters
        );
        $tempSet = null;
        
        for($currentLength = $length; $currentLength--; ) 
        {
            // Append a random ASCII character (only letters):
            $tempSet = rand(0, sizeof($charSets) - 1);
            $result .= chr(rand($charSets[$tempSet][0], $charSets[$tempSet][1]));
        }// for
        
        return $result;
    }//_randomString
}// User
