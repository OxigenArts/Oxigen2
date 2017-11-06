<?php


namespace Core\Objects;

class Headers {


    public static function setHeader($key, $value, $sb = '') {
        header("$key: $sb $value");
    }
}

?>