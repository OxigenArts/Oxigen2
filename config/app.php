<?php




//Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PW','');
define('DB_DB', 'test');

//App configuration
$APP_DIRECTORIES = [
    'objects-directory' => "Objects",
    'config-directory' => "config",
    'oxigen-class' => "core/oxigen.php",
    'module-directory' => "Modules",
    'exceptions-directory' => "Exceptions"
];

$PATH_CONFIGURATION = [
    'basepath' => "/Oxigen/Oxigen2/"
]

?>
