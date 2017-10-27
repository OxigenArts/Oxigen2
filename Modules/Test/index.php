<?php


use Core\Module;
;
class Test extends Module {
    public $name = "Test";
    public $tablename = "other_test";
    public $enabled = true;
    public $mainModule = true;
    public $routedMethods = [
        [
            'route' => 'strangemethod',
            'method' => 'GET'
        ],
        [
            'route' => 'test',
            'method' => 'GET'
        ]
    ];
    
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

    function test($a) {
        echo "test $a";
    }

    function othertest($name, $other) {
        echo "test $name $other";
    }

    function t() {
        echo "test none";
    }

    function strangemethod($a) {
        echo "this is a strange method with argument $a";
    }

    


}



?>