<?php

namespace Core\Objects;

class Table {
    public $columns = [];
    
    function __construct() {
    }

    function string($name, $properties = null) {
        $this->columns[$name] = "TEXT $properties";
    }

    function varchar($name, $length, $properties = null) {
        $this->columns[$name] = "VARCHAR($length) $properties";    
    }

    function integer($name, $properties = null, $length = null) {
        $this->columns[$name] = ($length) ? "INT($length) $properties" : "INT $properties";
    }

    function float($name, $properties = null, $lengthmin = null, $lengthmax = null) {
        $this->columns[$name] = ($lengthmin) ? (($lengthmax) ? "FLOAT($lengthmin, $lengthmax) $properties" : "FLOAT($lengthmin) $properties") : "FLOAT $properties";  
    }

    function double($name, $properties = null, $lengthmin = null, $lengthmax = null) {
        $this->columns[$name] = ($lengthmin) ? (($lengthmax) ? "DOUBLE($lengthmin, $lengthmax) $properties" : "DOUBLE($lengthmin) $properties") : "DOUBLE $properties";  
    }

}


?>