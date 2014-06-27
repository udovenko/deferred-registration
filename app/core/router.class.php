<?php
namespace core;


class Router 
{
    private static $_class = null;
    
    
    /**
     * перенаправление на контроллер 
     */
    public static function execute() 
    {
        
        $url = Url::getUrl();
               
        if (isset($url[0]))
        {
            $className = "\controllers\\" . ucfirst($url[0]);
            $class = new $className();
            
        } else {
    
            
            $class = new \controllers\Index();
            echo "zzzz";
            
        }    
            
            if (!is_object($class) || !$class instanceof $className) throw new Exception("Class $className not found");
           
                
            $methodName = $this->_getClassMethod($url);
            
            if (method_exists($class, $methodName))  throw new Exception("Method $methodName not found for class $className not found");
                
                $this->_checkAuth($class, $methodName);
                $data = $this->_getRequestData($url);
                echo $this->_setResult(call_user_func_array(array($class, $methodName), $data));
                
                
                
            
       
        $this->_class->performAction();
    }
    
    
    /**
     * получение текущего контроллера
     * @return object | null
     */
    public static function getController() 
    {
        return $this->_class;
    }
    
    
    /**
     * 
     * 
     * 
     * 
     */
    private function _getClassMethod($url) 
    {
        $request = new app\Request();
        $request_method = $request->getRequestMethod();

        switch ($request_method) {
            case 'GET':
                if (!empty($url[2]) && !is_numeric($url[2])) {                    // если передано имя метода
                    $methodName = $url[2];
                } else {
                    $methodName = 'get';//совпадает с именем метода в запросе
                }
                break;
            case 'POST':
                if (!empty($url[2])) {
                    if (is_numeric($url[2])) {
                        $methodName = 'update';
                    } else {
                        $methodName = $url[2];
                    }
                } else {
                    $methodName = 'create';
                }
                break;
            case 'PUT':
                if (!empty($url[2]) && is_numeric($url[2])) {
                    $methodName = 'update';//тут бы по-хорошему добавлять либо обновлять
                } else {
                    throw new \app\Error(404);
                }                
                break;
            case 'DELETE':
                if (!empty($url[2]) && is_numeric($url[2])) {
                    $methodName = 'delete';
                } else {
                    throw new \app\Error(404);
                }
                break;
            default:
                throw new \app\Error(405); //Method Not Allowed
                break;
        }
        return $methodName;
    }
}