<?php

namespace Core\Objects;

class Template {
    

    function __construct() {

    }

    public static function render($templatePath, $vars, $module = null) {


        $modelArr = [];

        foreach($vars as $key => $value) {

            //$GLOBALS[$key] = $value;
            if (!is_numeric($key)) {
                ${$key} = $value;
                $modelArr[$key] = $value; 
            } 

        }

        $model = (object) $modelArr;

        //print_r($GLOBALS['hola']);
        //print_r($vars);
        if ($module) {
            require_once("Templates/{$module->name}/".$templatePath.".php");
        } else {
            require_once("Templates/".$templatePath.".php");
        }
    }
}
