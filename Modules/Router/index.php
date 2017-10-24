<?php

use Core\Module;
require_once('Objects/Route.php');


class Router extends Module {
    public $name = "Router";
    public $fetchedRoute = [];
    public $routes = [];
    public $routeObj;

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
        $this->executeRoutes();
    }

    function executeRoutes() {
        $dRoot = $_SERVER['REQUEST_URI'];
        $fRoot = "/". str_replace($this->basepath, '', $dRoot);
        $reqMet = $_SERVER['REQUEST_METHOD'];

        //echo $fRoot;
        //echo $reqMet;
        foreach($this->routes as $route) {
            $route->execute($fRoot, $reqMet);
        }
    }

    function createContext($context, $callback) {

    }

    private function checkRoute($url) {
        if ($url[0] != "/") {
            $url = "/" . $url;
        }
        return $url;
    }

    /**
    * createRoute('/user/:id', 'GET', 'Users/get/:id')
    * 
    * Creates a direct Route
    */
    function createRoute($path, $method, $modulePath) {
        $path = $this->checkRoute($path);
        $r = new Route($this, $path, $method, $modulePath);
        $this->routes[] = $r;
    }

    /**
     * get('/user/:id', 'Users/get/:id')
     * 
     * Creates a GET method route
     */
    function getRoute($path, $modulePath) {
        $path = $this->checkRoute($path);
        $r = new Route($this, $path, 'GET', $modulePath);
        $this->routes[] = $r;
    }

    function hello($name) {
        echo "hello, $name";
    }







    



    


}



?>