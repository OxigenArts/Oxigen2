<?php


namespace Core;
use Core\Objects\QueryBuilder;
use Core\Objects\Database;
use Core\Objects\Table;
class Module {
    public $subModules = [];
    public $routedMethods = [];
    public $name = "defaultName";
    public $moduleRoute;
    public $tablename;
    public $isGlobal = true;
    public $enabled = true;
    public $generate_table = true;
    public $db;
    public $queryBuilder;
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
        if (count($this->subModules) > 0) {
            $this->oxigen->loader->loadSubModules($this->name, $this->subModules);
        }
        
    }

    function regSubModule($subModuleName) {
        $name = $this->name;
        $this->{$name} = $this->oxigen->{$subModuleName};
    }

    function __init__() {


        if (count($this->queryBuilder->rows) > 0) $this->generate();
        

        if (method_exists($this->name, 'init')) {
            $this->init();
        } else {
            //echo "there's not init function";
        }

        //$this->migrateTables();


        //$this->init();
    }

    function executeTableQuery($name, $newTable) {
        //print_r(array($name, $newTable));
        $this->__create_table($name, $newTable->columns);
    }

    function migrateTables() {
        if (file_exists($this->moduleRoute . "/tables.php") && $this->moduleRoute) {
            global $Module;
            $Module = $this;
            require_once($this->moduleRoute . "/tables.php");
        } else {
            //echo $this->moduleRoute . "/tables.php doesn't exists.";
        }
    }

    function table($name, $table) {
        $newTable = $table(new Table());
        $this->executeTableQuery($name, $newTable);
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
            $query = $this
                        ->queryBuilder
                        ->select()
                        ->build();
        } else {
            $query = $this
                        ->queryBuilder
                        ->select()
                        ->where($data)
                        ->build();
        }
        
        return $this->db->execute($query);
    }

    function update($id, Array $data) {
        $query = $this->queryBuilder->update()->where([
            'id' => [
                'operator' => '=',
                'value' => $id
            ]
        ])
            ->set($data)
            ->build();

        return $this->db->execute($query);
    }

    function updateWhere(Array $where, Array $data) {
        $query = $this
                ->queryBuilder
                ->update()
                ->where($where)
                ->set($data)
                ->build();

        return $this->db->execute($query);
    }

    function delete($id) {
        $query = $this
                ->queryBuilder
                ->delete()
                ->where([
                    'id' => [
                        'operator' => '=',
                        'value' => $id
                    ]
                ])
                ->build();
        return $this->db->execute($query);
    }

    function deleteWhere(Array $where) {
        $query = $this
                 ->queryBuilder
                 ->delete()
                 ->where($where)
                 ->build();
        return $this->db->execute($query);
    }

    function add(Array $data) {
        $query = $this
                 ->queryBuilder
                 ->insert()
                 ->withRows($data)
                 ->build();
        return $this->db->execute($query);
    }

    function __create_table($name, Array $data) {
        $query = $this
                 ->queryBuilder
                 ->create($name)
                 ->withColumns($data)
                 ->build();
        //echo $query . "</br>";
        return $this->db->execute($query);
    }

    function generate() {
        if ($this->generate_table) {
            $query = $this
                    ->queryBuilder
                    ->create($this->tablename)
                    ->build();
            return $this->db->execute($query);
        }
    }



    

    
}

?>