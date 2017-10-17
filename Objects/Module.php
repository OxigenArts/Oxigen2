<?php


namespace Core;
use Core\Objects\QueryBuilder;

class Module {
    public $subModules = [];
    public $name = "defaultName";
    public $tablename;
    public $isGlobal = true;
    public $enabled = true;
    private $queryBuilder;

    function __construct($oxigen) {
        $this->queryBuilder = new QueryBuilder();
        $this->oxigen = $oxigen;
        if ($this->tablename) {
            $this->queryBuilder->withTable($this->tablename);
        }

        //Init sequence
        $this->__init__();
    }

    function initSubModules() {
        $this->oxigen->loader->loadSubModules($this->name, $this->subModules);
    }

    function regSubModule($subModuleName) {
        $name = $this->name;
        $this->{$name} = $this->oxigen->{$subModuleName};
    }

    function __init__() {
        if (method_exists($this->name, 'init')) {
            $this->init();
        } else {
            echo "there's not init function";
        }


        //$this->init();
    }

    function migrateTables() {
        require_once("tables.php");
    }

    function get(int $id = null) {
        if (!$id) {
            $query = $this->queryBuilder->select()->build();
        } else {
            $query = $this->queryBuilder->where([
                'id' => [
                    'operator' => "=", 
                    'value' => $id
                ]
                ])->select()->build();
        }
        echo "query: " . $query;
    }

    function getWhere(Array $data = null) {
        $query = $this->queryBuilder($data)->select()->build();
        echo "query: " . $query;
    }




    

    
}

?>