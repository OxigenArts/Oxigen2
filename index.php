<?php
//carga de clases necesarias.
require_once('autoload.php');

use App\Oxigen;

$oxigen = new Oxigen("AppName");
$oxigen->init();

//print_r($oxigen);
?>
