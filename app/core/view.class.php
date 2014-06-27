<?php

namespace core;


/** 
 * View class. Allows to render templates with embeded PHP.
 * 
 * @author Denis Udovenko
 * @version 1.0.2
 */
class View
{
    
    private $_fileName;
    private $_data = array();
    
        
    /**
     * Returns a new View instance.
     * 
     * @param {String} $fileName View file name (relative to "views" dirrectory)
     * @return {View} New view instance for chaining calls
     */
    public static function forge($fileName)
    {
        return new static($fileName);
    }// forge
    
    
    /**
     * Public constructor.
     * 
     * @param {String} $fileName View file name (relative to "views" dirrectory)
     */
    public function __construct($fileName) 
    {
        $this->_fileName = APPPATH . "views" . DIRECTORY_SEPARATOR . $fileName . ".php";
    }// __construct
    
        
    /**
     *
     * 
     */
    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }// setData
    
    
    /**
     *
     * 
     */
    public function render()
    {
        $clean_room = function($__file_name, array $__data)
        {
            extract($__data, EXTR_REFS);
            
            // Capture the view output
            ob_start();

            try
            {
                    // Load the view within the current scope
                    include $__file_name;
            }
            catch (\Exception $e)
            {
                    // Delete the output buffer
                    ob_end_clean();

                    // Re-throw the exception
                    throw $e;
            }

            // Get the captured output and close the buffer
            return ob_get_clean();
        };
        
        return $clean_room($this->_fileName, $this->_data);
    }// render
}// View
