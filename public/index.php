<?php

// Website document root:
define('DOCROOT', __DIR__ . DIRECTORY_SEPARATOR);

// Project root:
define('PROJROOT', realpath(__DIR__  . '/..') . DIRECTORY_SEPARATOR);

// Path to the application directory:
define('APPPATH', realpath(__DIR__ . '/../app') . DIRECTORY_SEPARATOR);

try 
{
    echo "Loading router and executing current route<br/>";
    require_once APPPATH . 'core/boot.class.php';
    spl_autoload_register('\core\Boot::Autoload');
    //echo "loded register</br>";
    \core\Router::execute();
} catch (Exception $exception) {
    
    echo $exception;
}// catch