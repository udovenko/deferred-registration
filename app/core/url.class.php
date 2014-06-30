<?php
namespace core;


/**
 * Class for URL parsing.
 * 
 * @author Denis Udovenko
 * @version 1.0.1
 */
class Url 
{
    
    /**
     * @var {Array} An array of URL segments 
     */
    private static $_url = null;
    
    
    /**
     * Returns site base URL.
     * 
     * @static
     * @access public
     * @return {String} Site base URL
     */
    public static function getBase()
    {
        if(isset($_SERVER['HTTPS']))
        {
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        } else {
            
            $protocol = 'http';
        }// else
        
        return $protocol . "://" . $_SERVER['SERVER_NAME'];
    }// getBase
    
    
    /**
     * Splits URL into segments and return them as an array.
     * 
     * @static
     * @access public
     * @return {Array} Array of URL segments
     */
    public static function getUrl() 
    {
        self::_parseUrl();
        return self::$_url;
    }// getUrl
    
    
    /**
     * Parces current URL and puts resut into private field.
     *    
     * @static
     * @access private
     */
    private static function _parseUrl() 
    {
        if (isset($_GET['router'])) 
        {
            self::$_url = array_filter(explode('/', $_GET['router']));
            unset($_GET['router'], $_REQUEST['router']);
            
        } else {
            
            self::$_url = array();
        }// elses
    }// _parseUrl
}// Url