<?php

namespace core;


/**
 * Class contains methods for operations with HTTP request.
 * 
 * @author Denis Udovenko
 * @version 1.0.3
 */
class Request 
{
    
    const POST = 'post';
    const GET = 'get';
    const PUT = 'put';
    const DELETE = 'delete';
    
    private $_data = array();
    private $_headers = null;
   
    
    /**
     * 
     */
    public static function forge()
    {
        $request = new static();
        return $request;
    }// forge         
        
    
    /**
     * Returns HTTP request method name.
     * 
     * @return {String} HTTP request method name
     */
    public function getRequestMethod() 
    {
        return $_SERVER['REQUEST_METHOD'];
    }// getRequestMethod
    
    
    /**
     * получение заголовков запроса Apache
     * с заглушкой для nginx
     * @param string $key
     * @return array
     */
    public function getApacheLikeHeaders($key = null) {
        if (is_null($this->_headers)) {
            if (function_exists('apache_request_headers')) { // apache
                $this->_headers = apache_request_headers();
            } else { // nginx
                $this->_headers = '';
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $this->_headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
            }
        }

        if (is_null($key)) {
            return $this->_headers;
        } else {
            return isset($this->_headers[$key]) ? $this->_headers[$key] : null;
        }
    }
    
    /**
     * Receives request parameters depending on request type.
     * 
     * @param {String} $method Request method name
     * @return {Array | String} Request parameters
     */
    public function getData($method = null) 
    {
        if (is_null($method)) $request = strtolower($this->getRequestMethod());
        else $request = strtolower($method);
       
        switch ($request) 
        {
            case self::PUT:
                
                if (isset($this->_data[$request])) 
                {
                    return $this->_data[$request];
                } else {
                    
                    $dataStr = file_get_contents('php://input');
                    
                    $dataType = $this->getApacheLikeHeaders('Content-Type');
                    if (strstr($dataType, 'application/json') !== false) $data = json_decode($dataStr, true);
                    else parse_str($dataStr, $data);
                    
                    $this->_data[$request] = $data;
                    return $this->_data[$request];
                }// else
                
                break;
                
            case self::GET: case self::DELETE:
                
                if (isset($this->_data[$request])) 
                {
                    return $this->_data[$request];
                } else {
                    
                    $this->_data[$request] = $_GET;
                    $_GET = array();
                    return $this->_data[$request];
                }// else
                
                break;
                
            case self::POST:
                
                if (isset($this->_data[$request])) 
                {
                    return $this->_data[$request];
                } else {
                    
                    $dataType = $this->getApacheLikeHeaders('Content-Type');
                    if (strstr($dataType, 'application/json') !== false) 
                    {
                        $dataStr = file_get_contents('php://input');
                        $data = json_decode($dataStr, true);
                    } else {
                        
                        $data = $_POST;
                    }// else
                    
                    $this->_data[$request] = $data;
                    $_POST = array();
                    return $this->_data[$request];
                }// else
                
                break;
                
            default:
                
                return array();
        }// switch
    }// getData
}// Request