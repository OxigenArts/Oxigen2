<?php

use Core\Objects\Utils;
class RouteGroup {

    public $routes = [];


    function __construct($name, $parent) {
        $this->name = Utils::checkRoute($name);
        $this->parent = $parent;
    }

    /**
    * createRoute('/user/:id', 'GET', 'Users/get/:id')
    * 
    * Creates a direct Route
    */
    function createRoute($path, $method, $modulePath) {
        $path = Utils::checkRoute($path);
        $r = new Route($this->parent, $this->name . $path, $method, $modulePath);
        $this->routes[] = $r;
    }

    /**
    * execute($url, $method) 
    *
    * Execute the grouped routes
    */

    function execute($url, $method) {
        foreach($this->routes as $route) {
            $route->execute($url, $method);
        }
    }




}

?>