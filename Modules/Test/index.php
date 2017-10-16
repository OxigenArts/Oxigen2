<?php


use Core\Module;

class Test extends Module {
    public $name = "Test";
    public $tablename = "table";
    public $enabled = false;

    public $subModules = [
        'submoduleTest'
    ];

    
    function __construct($oxigen) {
        if (!$this->enabled) {
            return;
        }
        parent::__construct($oxigen);
        echo "Test instanced";
    }

    


}



?>