<?php

namespace Core\Objects;
use Core\Exceptions\QueryException;

//Query Builder 1
class QueryBuilder {

    private $query = "";

    function __construct() {

    }

    private function format_to_string($arr) {
        $formatted = "";
        foreach($arr as $item) {
            $formatted .= $item;
        }

        return trim($formatted, ",");
    }

    private function format_create_params($arr) {
        $formatted = "";
        foreach($arr as $paramKey => $paramValue) {
            $formatted .= "$paramKey $paramValue, ";
        }
        return trim(",", $formatted);
    }

    public function withColumns($columns) {
        $this->columns = $columns;
        return $this;
    }

    public function withRows($rows) {
        $this->rows = $rows;
        return $this;
    }

    public function addColumn($name, $arr_properties) {
        if (!$this->columns) {
            $this->columns = [];
        }

        $this->columns[$name] = $arr_properties;

        return $this;
    }

    public function removeColumn($name) {
        if (($key = array_search($name, $this->columns)) !== false) {
            unset($this->columns[$key]);
        } else {
            throw new QueryException("Can not remove column from Query if doesn't exist!");
        }
    }

    public function create($tablename) {
        $this->type = "create";
        $this->tablename = $tablename;
        return $this;
    }

    public function build() {
        switch($this->type) {
            case "create":
                if ($this->columns) {
                    if ($this->tablename) {
                        $create_string = $this->format_create_params($this->columns);
                        $this->query = "CREATE TABLE {$this->tablename} ($create_string)";
                        return $this->query;
                    } else {
                        throw new QueryException("No table name defined. Make sure that you are defining the table name before building a create query.");
                    }                 
                } else {
                    throw new QueryException("No columns defined. Make sure that you are defining columns before building a create query.");
                }
            break;
        }


    }


}


?>