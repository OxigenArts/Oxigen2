<?php

use Core\Module;
use Core\Objects\Utils;
require_once('Objects/Route.php');
require_once('Objects/RouteGroup.php');
require_once('Objects/Context.php');

class Router extends Module {
    public $name = "Router";
    public $fetchedRoute = [];
    public $routes = [];
    public $routeGroups = [];
    public $routeContexts = [];
    public $routeObj;
    public $routeExecuted = false;
    function __construct($oxigen) {
        global $PATH_CONFIGURATION;
        $this->basepath = $PATH_CONFIGURATION['basepath'];
        parent::__construct($oxigen);
        


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
        
        require_once('Oxigen/default.php');
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

        foreach($this->routeGroups as $routeGroup) {
            $routeGroup->execute($fRoot, $reqMet);
        }

        foreach($this->routeContexts as $routeContext) {
            $routeContext->execute($fRoot, $reqMet);
        }

        if (!$this->routeExecuted) {
            echo "Error 404";
        }
    }

    /**
    * createGroup('user', function(Group $group) {
    *   $group->get('/:id', 'User/get/:id')
    *   $group->get('/hello/:id');
    *   return $group;
    * })
    * 
    */
    function createGroup($group, $callback) {
        $g = $callback(new RouteGroup($group, $this));
        $this->routeGroups[] = $g;
    }


    /**
    * createRoute('/user/:id', 'GET', 'Users/get/:id')
    * 
    * Creates a direct Route
    */
    function createRoute($path, $method, $modulePath) {
        $path = Utils::checkRoute($path);
        $r = new Route($this, $path, $method, $modulePath);
        $this->routes[] = $r;
    }

    /**
     * get('/user/:id', 'Users/get/:id')
     * 
     * Creates a GET method route
     */
    function getRoute($path, $modulePath) {
        $path = Utils::checkRoute($path);
        $r = new Route($this, $path, 'GET', $modulePath);
        $this->routes[] = $r;
    }

    /**
    * createContext('Test')
    * 
    * Links a module with the router. 
    * Example:
    *       http:/myweb.page/Test/test/1
    */
    function createContext($modulePath) {
        $this->routeContexts[] = new Context($this, $modulePath);
    }

    function hello($name) {
        echo "hello, $name";
    }







    



    


}



?>