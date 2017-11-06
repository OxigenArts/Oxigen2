<?php

namespace Core\Objects;
use Core\Exceptions\NotFoundContentTypeException;
class Utils {


    private static $content_types = [
        'json' => 'application/json'
    ];

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

    public static function parseParameters($classname, $method, $params) {
        $reflection = new \ReflectionMethod($classname, $method);
        $values = [];
        print_r($params);
        foreach($reflection->getParameters() as $parameter) {
            $name = $parameter->getName();
            $isArgumentGiven = array_key_exists($name, $params);
            if (!$isArgumentGiven && !$parameter->isDefaultValueAvailable()) {
                die ("Parameter $name is mandatory but was not provided");
            }
        
            $values[$parameter->getPosition()] =
                $isArgumentGiven ? $params[$name] : $parameter->getDefaultValue();
        }

        return $values;


    }


    public static function content_type($type) {
        try {
            return self::$content_types[$type];
        } catch(NotFoundContentType $e) {
            print_r($e);
        }
        //return self::$content_types[$type] ? self::$content_types[$type] : null;
    }
    


}

?>