<?php

namespace core;


/** 
 *
 */
class Db
{
    const DB_HOST = "localhost";
    const DB_NAME = "registration";
    const DB_USER = "registration";
    const DB_PASS = "Ztn48cfg87vn";
    
    
    /**
     *
     * 
     */
    public static function forge()
    {        
        return new \PDO('mysql:host=' . static::DB_HOST . ';dbname=' . static::DB_NAME, 
            static::DB_USER, static::DB_PASS, 
            array(
            \PDO::ATTR_PERSISTENT => false,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        ));
    }// forge
}// Db