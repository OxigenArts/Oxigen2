<?php




//Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PW','741852966');
define('DB_DB', 'Test');


//App configuration
$APP_DIRECTORIES = [
    'objects-directory' => __DIR__ . "/Objects",
    'config-directory' => __DIR__ . "/config",
    'oxigen-class' => __DIR__ . "/core/oxigen.php",
    'module-directory' => __DIR__ . "/Modules",
    'exceptions-directory' => __DIR__ . "/Exceptions"
]

?>