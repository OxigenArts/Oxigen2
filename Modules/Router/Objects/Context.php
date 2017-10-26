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

    function getDefaultRoutedMethods() {
        return $this->parent->oxigen->{$this->_moduleName}->defaultRoutedMethods;
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
        //print_r($this->getDefaultRoutedMethods());
        $defRoutedMethods = $this->getDefaultRoutedMethods();
        $routedMethods = $this->getRoutedMethods();
        foreach($defRoutedMethods as $routedMethod) {
            $formattedParameters = $this->formattedFunctionParameters($routedMethod['function']);
            //echo $formattedParameters;
            //print_r($routedMethod);
            if ($routedMethod['route'] == "/") {
                $this->routes[] = new Route(
                    $this->parent, 
                    $this->moduleName . "/",
                    $routedMethod['method'],
                    $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                    );
            } else {
                $this->routes[] = new Route(
                    $this->parent, 
                    $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters,
                    $routedMethod['method'],
                    $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                    );
            }
           
                
                echo $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters . "</br>";
                echo $routedMethod['method'] . "</br>";
                echo $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters . "</br>";
        }

        foreach($routedMethods as $routedMethod) {
            //$formattedParameters = $this->formattedFunctionParameters($routedMethod['route']);
            //echo $formattedParameters;
            //print_r($routedMethod);
            if (array_key_exists("function", $routedMethod)) {
                //echo "function </br>";
                $formattedParameters = $this->formattedFunctionParameters($routedMethod['function']);
                $this->routes[] = new Route(
                    $this->parent, 
                    $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters,
                    $routedMethod['method'],
                    $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                );
            } else {
                //echo "route </br>";
                $formattedParameters = $this->formattedFunctionParameters($routedMethod['route']);
                $this->routes[] = new Route(
                    $this->parent, 
                    $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters,
                    $routedMethod['method'],
                    $this->_moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters
                );
            }
            
        }
    }

    function execute($url, $method) {
        foreach($this->routes as $route) {
            $route->execute($url, $method);
        }
    }



}


?>