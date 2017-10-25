<?php


class Route {
    
    public $paramPositions = [];
    public $parsedRoute = [];
    public $parsedModuleMethod = [];
    public $routeParameters = [];
    public $routeMatch = "";
    public $modulePath = "";
    
    function __construct($parent, $path, $method, $modulePath) {
        $this->parent = $parent;
        $this->path = $path;
        $this->modulePath = $modulePath;
        $this->routeMatch = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($this->path)) . "$@D";
        $this->method = $method;
    }

    function parseModuleMethod() {
        $this->parsedModuleMethod = explode("/", $this->modulePath);
        //print_r($this->parsedModuleMethod);
    }

    function execute($url, $method) {
        
        $this->getPathParameters();
        $this->parseModuleMethod();

        $matches = [];
        if ($method == $this->method && preg_match($this->routeMatch, $url, $matches)) {
            array_shift($matches);
            $this->routeParameters = $matches;
            $this->call_module_method();
            $this->parent->routeExecuted = true;
            //echo $this->path;
        }
    }

    function call_module_method() {
        call_user_func_array(
            [
                $this->parent->oxigen->{$this->parsedModuleMethod[0]},
                $this->parsedModuleMethod[1]
            ], 
            $this->routeParameters
        );
    }

    function getParamPosition($index) {
        return $this->paramPositions[$index];
    }

    function getPathParameters() {
        $m = [];
        
        preg_match("/(?<!\w):\w+/", $this->path, $m);
        $this->paramPositions = $m;
        
        //print "</br>" . $this->path . "</br>";
        //print_r($this->paramPositions);
    }

    

}


?>