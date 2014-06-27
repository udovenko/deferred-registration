<?php
namespace core;



class Boot 
{

    
    public static function Autoload($name) 
    {
        
        $path = str_replace('\\', DIRECTORY_SEPARATOR, sprintf(APPPATH . "%s.class.php", strtolower($name)));
        
        if (is_file($path)) {
            
            include $path;
        } else {
            
            throw new Exception("File $path not found");
        }
    }
}