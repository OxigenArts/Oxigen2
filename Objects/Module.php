<?php


namespace Core;

class Module {
    public $subModules = [];
    public $name = "defaultName";
    
    function __construct($oxigen) {
        $this->oxigen = $oxigen;
    }

    function initSubModules() {
        $this->oxigen->loader->loadSubModules($this->name, $this->subModules);
    }

    
}

?>