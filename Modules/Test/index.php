<?php


use Core\Module;

class Test extends Module {
    public $name = "test";

    public $subModules = [
        'submoduleTest'
    ];

    function __construct($oxigen) {
        parent::__construct($oxigen);
        parent::initSubModules();
        echo "Test instanced";
    }


}



?>