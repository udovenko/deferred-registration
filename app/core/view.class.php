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
     * @static
     * @access public
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
     * @access public
     * @param {String} $fileName View file name (relative to "views" dirrectory)
     */
    public function __construct($fileName) 
    {
        $this->_fileName = APPPATH . "views" . DIRECTORY_SEPARATOR . $fileName . ".php";
    }// __construct
    
        
    /**
     * Sets up view data which will be transformed into view variables.
     * 
     * @access public
     * @param {Array} $data View values hash
     * @return {View} Current view instance
     */
    public function setData($data)
    {
        $this->_data = $data;
        return $this;
    }// setData
    
    
    /**
     * Render view from template and passes data.
     * 
     * @access public
     * @return {String} Rendered view
     */
    public function render()
    {
        extract($this->_data, EXTR_REFS);

        // Capture the view output
        ob_start();

        try
        {
            // Load the view within the current scope:
            include $this->_fileName;
        }
        catch (\Exception $e)
        {
            // Delete the output buffer:
            ob_end_clean();

            // Re-throw the exception:
            throw $e;
        }

        // Get the captured output and close the buffer
        return ob_get_clean();
    }// render
}// View
