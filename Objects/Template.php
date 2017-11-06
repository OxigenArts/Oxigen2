<?php

namespace Core\Objects;

use Core\Objects\Headers;
use Core\Objects\Utils;

class Template {
    

    function __construct() {

    }

    public static function renderFormattedResponse($modelArr, $type = 'json') {
        Headers::setHeader('Content-Type', Utils::content_type($type));
        switch($type) {
            case 'json':
                echo json_encode($modelArr);
            break;
            default:
                echo "fatal error: Content-Type not identified"; 
            break;
        }
    }

    public static function render($templatePath, $vars, $module = null, $type = null) {


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

        if ($type) {
            Utils::renderFormattedResponse($modelArr, $type);
            return;
        }
        

        if ($module) {
            require_once("Templates/{$module->name}/".$templatePath.".php");
        } else {
            require_once("Templates/".$templatePath.".php");
        }
    }
}
