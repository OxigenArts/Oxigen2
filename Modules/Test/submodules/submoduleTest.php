<?php

use Core\Module;
class submoduleTest extends Module {

    function __construct($oxigen) {
        $this->name = "SubModuleTest";
        echo "{$this->name} instanced";
    }
}

?>