<?php

use Core\Module;

class Router extends Module {
    public $name = "Router";
    public $fetchedRoute = [];
    public $routes = [];
    function __construct($oxigen) {
        global $PATH_CONFIGURATION;
        $this->basepath = $PATH_CONFIGURATION['basepath'];
        parent::__construct($oxigen);
        //echo "Router instanced";
    }

    function init() {
        
    }

    function start() {
        $dRoot = $_SERVER['REQUEST_URI'];
        $fRoot = str_replace($this->basepath, '', $dRoot);
        foreach(explode("/", $fRoot) as $part) {
            array_push($this->fetchedRoute, $part);
                
        }
        global $Router;
        $Router = $this;
        require_once('routes.php');
    }

    function createContext($context, $callback) {

    }

    /**
    * createRoute('/user/:id', 'Users/get/:id')
    * 
    * Creates a direct Route
    */
    function createRoute($path, $method) {
            
    }





    



    


}



?>