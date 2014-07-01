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
    const PASSWORD_SALT             = "$2a$10$1qAz2wSx3eDc4rFv5tGb5t";
    
    private $_id;
    private $_email;
    private $_name;
    private $_encryptedPassword;
    private $_createdAt;
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
        return new static($email, $name, null);
    }// forge
    
    
    /**
     * Public constructor.
     * 
     * @access public
     * @param {String} $email Users e-mail
     * @param {String} $name User name
     * @param {String} $id User identifier
     * @param {String} $createdAt User creation timestamp
     */
    public function __construct($email = null, $name = null, $id = null, $createdAt = null)
    {
        $this->_email = $email;
        $this->_name = $name;
        $this->_id = $id;
        $this->_createdAt = $createdAt;
    }// __construct
    
    
    /**
     * Validates current current instance fields. 
     * 
     * @access public
     * @retrun {Boolean} Is model valid
     */
    public function validate()
    {
        // Reseting errors array:
        $this->_errors = array();
        
        
        // Validation rules for e-mail:
        $trimmedEmail = trim($this->_email);
        if (!isset($this->_email) || empty($trimmedEmail))
            $this->_errors[] = "email is empty";
        
        if (!preg_match("/\A[\w+\-.]+@[a-z\d\-]+(\.[a-z]+)*\.[a-z]+\z/i", $this->_email)) 
            $this->_errors[] = "email has invalid format";
        
        $users = static::findBy(array("email" => $this->_email));
        if (!empty($users)) $this->_errors[] = "email is already taken";
        
        // Validation rules for name:
        $trimmedName = trim($this->_name);
        if (!isset($this->_name) || empty($trimmedName))
            $this->_errors[] = "name is empty";

        if (strlen($this->_name) > 20) $this->_errors[] = "name is too long (only 20 characters is allowed)";
                
        return empty($this->_errors); 
    }// validate
    
    
    /**
     * Saves user. If user has id - updates his attributes, if hasn't - inserts
     * new one into database.
     * 
     * @access public
     */
    public function save()
    {
        $database = \core\Db::forge();
        
        if (!isset($this->_id))
        {
            $insertUserQueryText = "INSERT INTO `users` (`email`,`name`, `password`) VALUES (?, ?, ?)";

            $insertUserQuery = $database->prepare($insertUserQueryText);

            $insertUserQuery->bindParam(1, $this->_email);
            $insertUserQuery->bindParam(2, $this->_name);
            $insertUserQuery->bindParam(3, $this->_encryptedPassword);

            $insertUserQuery->execute();

            $this->_id = $database->lastInsertId();
            
        } else {
            
            // Update attributes
        }// else
    }// save
  
    
    /**
     * Determines if models is new by its identifier.
     * 
     * @access public
     * @return {Boolean} Is model new
     */
    public function isNew()
    {
        return $this->_id === null;
    }// isNew
    
    
    /**
     * Returns current model identifier.
     * 
     * @access public
     * @return {Integer} Current model identifier
     */
    public function getId()
    {
        return $this->_id;
    }// getId
    
    
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
     * Returns registration token.
     * 
     * @access public
     * @return {String} Current user name
     */
    public function getRegistrationToken()
    {
        return $this->_token;        
    }// _getRegistrationToken
    
    
    /**
     * Returns user creation timestamp.
     * 
     * @access public
     * @return {Integer} User creation timestamp
     */
    public function getCreatedAt()
    {
        return $this->_createdAt;
    }// getCreatedAt
    
    
    /**
     * Returns generated password.
     * 
     * @access public
     */
    public function encryptAndSetPassword($password)
    {
        $this->_encryptedPassword = static::encryptPassword($password);
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
     * Finds model in database by given attributes.
     * 
     * @static
     * @access public
     * @param {Array} $conditions Search conditions (field => value)
     * @return {Array} Array of found instances
     */    
    public static function findBy($conditions)
    {
        $database = \core\Db::forge();
        
        $usersQueryText = "SELECT * FROM `users` WHERE ";
        $conditionsCount = 0;
        foreach ($conditions as $field => $value)
        {
            if ($conditionsCount) $usersQueryText .= " AND "; 
            $usersQueryText .= "`" . filter_var($field, FILTER_SANITIZE_STRING) . "` = :$field";
            $conditionsCount++;
        }// foreach

        $usersQuery = $database->prepare($usersQueryText);
        foreach ($conditions as $field => $value) $usersQuery->bindValue(":$field", $value, \PDO::PARAM_STR);

        $usersQuery->execute();
     
        $result = array();
        while ($user = $usersQuery->fetch())
        {
            $result[] = new static($user->email, $user->name, $user->id, strtotime($user->created_at));
        }//while
        
        return $result;
    }// findBy
    
    
    /**
     * Generates registration token.
     * 
     * @static
     * @access private
     */
    public static function generateRegistrationToken()
    {        
        return static::_randomString(static::REGISTRATION_TOKEN_LENGTH);
    }// _generateRegistrationToken
    
    
    /**
     * Generates user password.
     * 
     * @static
     * @access private
     */
    public static function generatePassword()
    {
        // Initialize a random desired length:
        $length = rand(static::PASSWORD_MIN_LENGTH, static::PASSWORD_MAX_LENGTH);
        return static::_randomString($length);
    }// sendRegistrationMail
    
    
    /**
     * Encrypts current password with "bcrypt" algorythm.
     * 
     * @return {String} Encrypted password
     */
    public static function encryptPassword($password)
    {
        return substr(crypt($password,  static::PASSWORD_SALT), 28);
    }// _encryptPassword
    
    
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
