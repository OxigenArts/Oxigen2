<?php

namespace Core\Objects;

class Utils {

    public static function checkRoute($url) {
        if ($url[0] != "/") {
            $url = "/" . $url;
        }
        return $url;
    }


    public static function getNumberOfParameters($classname, $method) {
        $reflection = new \ReflectionMethod($classname, $method);
        $params = [];
        //print_r($reflection->getParameters());
        
        foreach($reflection->getParameters() as $parameter) {
            $params[] = $parameter->name;
        }
        return $params;
    }
    


}

?>