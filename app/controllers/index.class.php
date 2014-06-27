<?php

namespace controllers;

/** 
 * 
 */
class Index
{
    
    public function __construct() {
        echo "construct";
        //Reg::Get('\app\Response')->setHeader('Content-Type:application/json; charset=utf-8');
    }
    
    public function get()
    {
        echo "index page!!!";
    }
}
