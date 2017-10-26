<?php

namespace Core\Objects;

class Template {
    

    function __construct() {

    }

    public static function render($templatePath, $vars, $module = null) {

        foreach($vars as $key => $value) {
            //$GLOBALS[$key] = $value;
            ${$key} = $value;
        }

        //print_r($GLOBALS['hola']);

        if ($module) {
            require_once("Templates/{$module->name}/".$templatePath.".php");
        } else {
            require_once("Templates/".$templatePath.".php");
        }
    }
}
