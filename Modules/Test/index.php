<?php


use Core\Module;

class Test extends Module {
    public $name = "Test";
    public $tablename = "table";
    public $subModules = [
        'submoduleTest'
    ];

    function __construct($oxigen) {
        parent::__construct($oxigen);
        echo "Test instanced";
    }

    


}



?>