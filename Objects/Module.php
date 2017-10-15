<?php


namespace Core;
use Core\Objects\QueryBuilder;

class Module {
    public $subModules = [];
    public $name = "defaultName";
    public $tablename;
    public $isGlobal = true;
    private $queryBuilder;

    function __construct($oxigen) {
        $this->queryBuilder = new QueryBuilder();
        $this->oxigen = $oxigen;
        if ($this->tablename) {
            $this->queryBuilder->withTable($this->tablename);
        }
    }

    function initSubModules() {
        $this->oxigen->loader->loadSubModules($this->name, $this->subModules);
    }

    function regSubModule($subModuleName) {
        $name = $this->name;
        $this->{$name} = $this->oxigen->{$subModuleName};
    }

    function get($id = null) {
        if (!$id) {
            $query = $this->queryBuilder->select()->build();
        } else {
            $query = $this->queryBuilder->where([
                'id' => [
                    'operator' => "=", 
                    'value' => $id
                ],
                'name' => [
                    'operator' => "=",
                    'value' => "Angel"
                ]
                ])->select()->build();
        }
        echo "query: " . $query;
    }




    

    
}

?>