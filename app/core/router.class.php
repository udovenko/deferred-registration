<?php

namespace core;


/**
 * Implements basic routing with URL params. Acts as Front controller for 
 * application.
 *  
 * @author Denis Udovenko
 * @version 1.0.3
 */
class Router 
{
    
    /**
     * Redirects URL string to controllers actions and handles results.
     * 
     * @static
     * @access public
     */
    public static function execute()
    {
        $url = Url::getUrl();
        
        // If URL contains controller name:
        if (isset($url[0]))
        {
            $className = "\controllers\\" . ucfirst($url[0]);
            $class = new $className();
            
        } else { // If URL is root:
             
            $className = "\controllers\\Index";
            $class = new $className();
        }// else   
        
        // Checking that created controller instance is valid:
        if (!is_object($class) || !$class instanceof $className) 
            throw new \Exception("Class $className not found");
        
        $methodName = self::_getClassMethod($url);

        // Checking that controller has recevid method:
        if (!method_exists($class, $methodName)) 
            throw new \Exception("Method $methodName not found for class $className not found");
                
        $responceBody = call_user_func(array($class, $methodName));
        
        \core\Response::forge($responceBody)
            ->setHeader("Content-Type", "text/html; charset=utf-8")
            ->send(true);
    }// execute
    
    
    /**
     * Determines controller method name from given URL.
     * 
     * @static
     * @access public
     * @param {Array} $url URL segments array 
     * @return {String} Method name
     */
    private static function _getClassMethod($url) 
    {
        $request = new \core\Request();
        $request_method = $request->getRequestMethod();

        switch ($request_method) 
        {
            case 'GET':
                
                if (!empty($url[1]) && !is_numeric($url[1])) $methodName = $url[1];
                else $methodName = 'get';
                
                break;
                
            case 'POST':
                
                if (!empty($url[1])) 
                {
                    if (is_numeric($url[1])) $methodName = 'update';
                    else $methodName = $url[1];
                    
                } else {
                    $methodName = 'create';
                }// elses
                
                break;
                
            default:
                
                throw new \Exception("Method detection error");
                break;
        }// switch
        
        return $methodName;
    }// _getClassMethod
}// Router