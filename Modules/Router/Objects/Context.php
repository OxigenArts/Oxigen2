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

    function isMainModule() {
        return $this->parent->oxigen->{$this->_moduleName}->mainModule;
    }

    function formattedFunctionParameters($methodName, $methodUrl) {
        $params = Utils::getNumberOfParameters($this->_moduleName, $methodName);
        //print_r($params);
        $str = "";

        if ($methodUrl == "POST") {
            return "";
        }
        foreach($params as $paramKey => $paramValue) {
            $str .=  ":$paramValue/";
        }
        //echo $str;
        return trim($str, "/");
    }

    function generateRoutedMethods() {
        $routedMethods = $this->getRoutedMethods();
        foreach($routedMethods as $routedMethod) {
            //$formattedParameters = $this->formattedFunctionParameters($routedMethod['route']);
            //echo $formattedParameters;
            //print_r($routedMethod);

            if ($this->isMainModule()) {
                if (array_key_exists("function", $routedMethod)) {
                    //echo "function </br>";
                    $formattedParameters = $this->formattedFunctionParameters($routedMethod['function'], $routedMethod['method']);
                    $this->routes[] = new Route(
                        $this->parent, 
                        "/" . $routedMethod['route'] . "/" . $formattedParameters,
                        $routedMethod['method'],
                        $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                    );
                } else {
                    //echo "route </br>";
                    $formattedParameters = $this->formattedFunctionParameters($routedMethod['route'], $routedMethod['method']);
                    $this->routes[] = new Route(
                        $this->parent, 
                        "/" . $routedMethod['route'] . "/" . $formattedParameters,
                        $routedMethod['method'],
                        $this->_moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters
                    );
                }
            } else {
                if (array_key_exists("function", $routedMethod)) {
                    //echo "function </br>";
                    $formattedParameters = $this->formattedFunctionParameters($routedMethod['function'], $routedMethod['method']);
                    $this->routes[] = new Route(
                        $this->parent, 
                        $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters,
                        $routedMethod['method'],
                        $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                    );
                } else {
                    //echo "route </br>";
                    $formattedParameters = $this->formattedFunctionParameters($routedMethod['route'], $routedMethod['method']);
                    $this->routes[] = new Route(
                        $this->parent, 
                        $this->moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters,
                        $routedMethod['method'],
                        $this->_moduleName . "/" . $routedMethod['route'] . "/" . $formattedParameters
                    );
                }
            }
            
            
        }
    }
    
    function generateDefaultRoutedMethods() {
        $defRoutedMethods = $this->getDefaultRoutedMethods();
        foreach($defRoutedMethods as $routedMethod) {
            $formattedParameters = $this->formattedFunctionParameters($routedMethod['function'], $routedMethod['method']);
            if ($this->isMainModule()) {
                if ($routedMethod['route'] == "/" || $routedMethod['route'] == "") {
                    $this->routes[] = new Route(
                        $this->parent, 
                        "/" . $formattedParameters,
                        $routedMethod['method'],
                        $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                        );
                } else {
                    echo Utils::checkRoute($routedMethod['route']) . "/" . $formattedParameters . "</br>";
                    $this->routes[] = new Route(
                        $this->parent, 
                        Utils::checkRoute($routedMethod['route']) . "/" . $formattedParameters,
                        $routedMethod['method'],
                        $this->_moduleName . "/" . $routedMethod['function'] . "/" . $formattedParameters
                        );
                }
            } else {
                if ($routedMethod['route'] == "/" || $routedMethod['route'] == "") {
                    $this->routes[] = new Route(
                        $this->parent, 
                        $this->moduleName . "",
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
            }
            

        }
    }

    function generateRoutes() {
        $this->generateDefaultRoutedMethods();
        $this->generateRoutedMethods();
    }

    function execute($url, $method) {
        foreach($this->routes as $route) {
            $route->execute($url, $method);
        }
    }



}


?>