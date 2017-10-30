<?php

namespace Core\Objects;

class Request {

    public $rawData;
    function __construct() {
        $this->rawData = $_POST;
    }


    function postData() {
        return $this->rawData;
    }
    function test() {
        print_r($this->rawData);
    }


}


?>