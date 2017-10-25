<?php


use Core\Objects\Utils;

class Context {

    public $parent;
    public $moduleName;
    public $_moduleName;
    public $routes = [];

    function __construct($parent, $module) {
        $this->_moduleName = $module;
        $this->moduleName = Utils::checkRoute($module);
        $this->parent = $parent;
        $this->generateRoutes();
    }

    function getRoutedMethods() {
        return $this->parent->oxigen->{$this->_moduleName}->routedMethods;
    }

    function formattedFunctionParameters($methodName) {
        $params = Utils::getNumberOfParameters($this->_moduleName, $methodName);
        //print_r($params);
        $str = "";
        foreach($params as $paramKey => $paramValue) {
            $str .=  ":$paramValue/";
        }
        //echo $str;
        return trim($str, "/");
    }

    function generateRoutes() {
        foreach($this->getRoutedMethods() as $routedMethod) {
            $formattedParameters = $this->formattedFunctionParameters($routedMethod['route']);
            //echo $formattedParameters;

            $this->routes[] = new Route(
                $this->parent, 
                $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters,
                $routedMethod['method'],
                $this->_moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters);
        }
    }

    function execute($url, $method) {
        foreach($this->routes as $route) {
            $route->execute($url, $method);
        }
    }



}


?>