<?php
namespace core;


/**
 * Includes methods necessary for booting application.
 * 
 * @author Denis Udovenko
 * @version 1.0.2
 */
class Boot 
{

    /**
     * Application classes autoload method.
     * 
     * @param {String} $name Class name
     * @throws \Exception
     */
    public static function Autoload($name) 
    {
        
        $path = str_replace('\\', DIRECTORY_SEPARATOR, sprintf(APPPATH . "%s.class.php", strtolower($name)));
        
        if (is_file($path)) include $path;
        else throw new \Exception("File $path not found");
    }// Autoload
}// Boot