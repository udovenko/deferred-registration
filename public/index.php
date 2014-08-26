<?php

error_reporting(-1);
ini_set('display_errors', 1);

// Website document root:
define('DOCROOT', __DIR__ . DIRECTORY_SEPARATOR);

// Project root:
define('PROJROOT', realpath(__DIR__  . '/..') . DIRECTORY_SEPARATOR);

// Path to the application directory:
define('APPPATH', realpath(__DIR__ . '/../app') . DIRECTORY_SEPARATOR);

try 
{
    // Loading application classes:
    require_once APPPATH . 'core/boot.class.php';
    spl_autoload_register('\core\Boot::Autoload');
    
    // Executing router:
    \core\Router::execute();
} catch (Exception $exception) {
    
    echo $exception;
}// catch