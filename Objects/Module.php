<?php


namespace Core;
use Core\Objects\QueryBuilder;
use Core\Objects\Database;
class Module {
    public $subModules = [];
    public $name = "defaultName";
    public $tablename;
    public $isGlobal = true;
    public $enabled = true;
    private $db;
    private $queryBuilder;
    function __construct($oxigen) {
        if (!$this->enabled) {
            return;
        }

        $this->queryBuilder = new QueryBuilder();
        
        $this->oxigen = $oxigen;
        if ($this->tablename) {
            $this->queryBuilder->withTable($this->tablename);
            $this->db = new Database($this->tablename);
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
            //echo "there's not init function";
        }


        //$this->init();
    }

    function migrateTables() {
        require_once("tables.php");
    }

    function get($id = null) {
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

        //print $query;

        //print_r($this->db->execute($query)[0]);
        return $this->db->execute($query)[0];
    }

    function getWhere(Array $data = null) {
        $query = $this->queryBuilder->select()->where($data)->build();
        return $this->db->execute($query)[0];
        
    }

    function getAll(Array $data = null) {
        if (!$data) {
            $query = $this->queryBuilder->select()->build();
        } else {
            $query = $this->queryBuilder->select()->where($data)->build();
        }
        
        return $this->db->execute($query);
    }



    

    
}

?>