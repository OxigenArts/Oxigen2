<?php

namespace Core\Objects;
use Core\Exceptions\QueryException;

/**
 * Query Builder Class
 * Version: ALPHA 1
 * Author: Angel González, Pablo Androetto.
 * Last change: 15/10/2017 6:17PM GMD-4:00
 */
class QueryBuilder {

    public $query = "";
    public $where;
    public $order_by = "";
    public $rows = [];
    public $columns = [];
    public $table = "";
    function __construct() {

    }

    private function is_last($item, $arr) {
        if ($item == end($arr)) {
            return true;
        }
        return false;
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
            $formatted .= "$paramKey $paramValue,";
        }
        return trim($formatted, ",");
    }

    private function format_insert_rows($arr) {
        $columns = [];
        $values = [];
        $columnString = "(";
        $valuesString = "(";


        foreach($arr as $paramKey => $paramValue) {
            if (!is_numeric($paramValue)) {
                $pVal = "'$paramValue'";
            }
            array_push($columns, $paramKey);
            array_push($values, $pVal);
        }

        foreach($columns as $column) {
            if ($this->is_last($column, $columns)) {
                $columnString .= "$column)";
            } else {
                $columnString .= "$column, ";
            }
        }

        foreach($values as $value) {
            if ($this->is_last($value, $values)) {
                $valuesString .= "$value)";
            } else {
                $valuesString .= "$value, ";
            }
        }

        return [
            'columns' => $columnString,
            'values' => $valuesString
        ];
    }

    private function format_update_set($arr) {
        $formatted = "";
        //print_r($arr);
        foreach($arr as $paramKey => $paramValue) {
            if (!is_numeric($paramValue)) {
                $pVal = "'$paramValue'";
            }
            $formatted .= "$paramKey=$pVal,";
        }

        return trim($formatted, ",");
    }

    private function format_where($arr) {
        $formatted = "";
        foreach($arr as $paramKey => $paramValue) {
            $operator = $paramValue['operator'];
            $value = $paramValue['value'];
            if (!is_numeric($value)) {
                $value = "'$value'";
            }
            if ($this->is_last($arr[$paramKey], $arr)) {
                $formatted .= "{$paramKey} {$operator} {$value}";
            } else {
                $formatted .= "'{$paramKey}' {$operator} '{$value}' AND ";
            }
            
        }
        return $formatted;
    }

    public function withColumns($columns) {
        //withColumns(['id' => 'UNSIGNED INT UNIQUE']);
        $this->columns = $columns;
        return $this;
    }

    public function withRows($rows) {
        //withRows([['name' => "Admin", 'password' => "1234"]]);
        $this->rows = $rows;
        return $this;
    }

    public function withTable($table) {
        //withTable("users");
        $this->table = $table;
    }

    public function addColumn($name, $arr_properties) {
        //addColumn("name", ['TEXT', 'UNIQUE']);
        if (!$this->columns) {
            $this->columns = [];
        }

        $this->columns[$name] = $arr_properties;

        return $this;
    }

    public function removeColumn($name) {
        //removeColumn("name")
        if (($key = array_search($name, $this->columns)) !== false) {
            unset($this->columns[$key]);
        } else {
            throw new QueryException("Can not remove column from Query if doesn't exist!");
        }

        return $this;
    }

    public function set($arr) {
        //set(['name' => 'othername']);
        $this->setParams = $arr;
        return $this;
    }

    public function where($arr) {
        //where(['id' => ['operator' => '=', 'value' => 1]]);
        $this->where = $arr;
        return $this;
    }

    public function order_by($orderStr) {
        //order_by("id ASC")
        $this->order_by = $orderStr;
        return $this;
    }

    public function create($table = null) {
        //create("users")
        $this->type = "create";
        $this->table = $table;
        return $this;
    }

    public function update() {
        //update()
        $this->type = "update";
        return $this;
    }

    public function insert() {
        $this->type = "insert";
        return $this;
    }

    public function delete() {
        $this->type = "delete";
        return $this;
    }

    public function select($select = "*") {
        $this->select = $select;
        $this->type = "select";
        return $this;
    }

    

    public function build() {
        switch($this->type) {
            case "create":
                if ($this->columns) {
                    if ($this->table) {
                        $create_string = $this->format_create_params($this->columns);
                        $this->query = "CREATE TABLE IF NOT EXISTS {$this->table} ($create_string)";
                        return $this->query;
                    } else {
                        throw new QueryException("No table name defined. Make sure that you are defining the table name before building a create query.");
                    }                 
                } else {
                    throw new QueryException("No columns defined. Make sure that you are defining columns before building a create query.");
                }
            break;

            case "update":
                if ($this->table) {
                    if ($this->setParams) {
                        $set = $this->format_update_set($this->setParams);
                        echo "$set </br>";
                        if ($this->where) {
                                $where = $this->format_where($this->where);
                                $this->query = "UPDATE {$this->table} SET $set WHERE $where";
                        } else {
                                $this->query = "UPDATE {$this->table} SET $set";
                        }
                    } else {
                        throw new QueryException("Set params has to be defined. (QueryBuilder::set)");
                    }
                } else {
                    throw new QueryException("Table name not specified. (QueryBuilder::withTable)");
                }
                return $this->query;
            break;

            case "delete":
                if ($this->table) {
                    if ($this->where) {
                        $where = $this->format_where($this->where);
                        $this->query = "DELETE FROM {$this->table} WHERE $where"; 
                    } else {
                        $this->query = "DELETE FROM {$this->table}";
                    }
                } else {
                    throw new QueryException("Table name not specified. (QueryBuilder::withTable)");
                }
                return $this->query;
            break;

            case "insert":
                if ($this->table) {
                    if ($this->rows) {
                        $rows = $this->format_insert_rows($this->rows);
                        $columns = $rows['columns'];
                        $values = $rows['values'];
                        $this->query = "INSERT INTO {$this->table} $columns VALUES $values";
                    } else {
                        throw new QueryException("Rows not specified. (QueryBuilder::withRows)");
                    }
                } else {
                    throw new QueryException("Table name not specified. (QueryBuilder::withTable)");
                }
                return $this->query;
            break;

            case "select":
                if ($this->table) {
                    if ($this->where) {
                        $where = $this->format_where($this->where);
                        $this->query = "SELECT {$this->select} FROM {$this->table} WHERE $where {$this->order_by}";
                        //print $this->query . "</br>";
                    } else {
                        $this->query = "SELECT {$this->select} FROM {$this->table} {$this->order_by}";
                    }
                } else {
                    throw new QueryException("Table name not specified. (QueryBuilder::withTable");
                }
                return $this->query;
            break;

            default:
                throw new QueryException("Type operation not recognized or uknown (QueryBuilder::$ type");
            break;
        }


    }


}


?>