<?php

namespace Core\Objects;

class Table {
    function __construct($tablename) {
        $this->tablename = $tablename;
    }

    public function generateTable() {
        return $this;
    }

    public function destroyTable() {
        return $this;
    }

    public function getBy($rowName, $rowRef, $expression = "=") {
        return $this;
    }

    public function getAll() {
        return $this;
    }

    public function delete() {
        return $this;
    }

    public function update() {
        return $this;
    }

    public function insert() {
        return $this;
    }

    public function exchangeId() {
        return $this;
    }

}


?>