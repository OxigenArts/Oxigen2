<?php


use Core\Module;
;
class Test extends Module {
    public $name = "Test";
    public $tablename = "test_table";
    public $enabled = true;

    public $subModules = [
        'submoduleTest'
    ];

    
    function __construct($oxigen) {
        
        parent::__construct($oxigen);
        //echo "Test instanced";

        //print_r($this->getAll());
    }

    


}



?>