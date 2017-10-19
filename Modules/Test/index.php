<?php


use Core\Module;
;
class Test extends Module {
    public $name = "Test";
    public $tablename = "other_test";
    public $enabled = true;

    public $subModules = [
        'submoduleTest'
    ];

    
    function __construct($oxigen) {
        
        parent::__construct($oxigen);
        
        $this
            ->queryBuilder
            ->addColumn("id", "INT UNSIGNED PRIMARY KEY AUTO_INCREMENT")
            ->addColumn("user", "TEXT")
            ->addColumn("password", "TEXT");
        $this->generate();
    }

    


}



?>