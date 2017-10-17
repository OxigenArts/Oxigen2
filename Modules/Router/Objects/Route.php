<?php


class Route {
    
    public $paramPositions = [];
    
    function __construct($parent, $path, $method) {
        $this->parent = $parent;
        $this->path = $path;
        $this->method = $method;
    }

    function formatRoute() {

    }

    function execute($params) {
        
    }

    function getPathParameters() {
        $m = [];
        preg_match("/(?<!\w):\w+/", $this->path, $m);
        $this->paramPositions = $m;

        print_r($this->paramPositions);
    }

    

}


?>