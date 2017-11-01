<?php

namespace Core\Objects;

class Request {

    public $rawData;
    function __construct() {
        $this->rawData = $_POST;
        $this->rdata = $_REQUEST;
    }


    function postData() {
        return $this->rawData;
    }

    function data() {
        return $this->rdata;
    }
    function test() {
        print_r($this->rawData);
    }


}


?>