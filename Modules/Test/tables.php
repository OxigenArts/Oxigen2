<?php
use Core\Objects\Table;

global $Module;
$Module->table("test_table_", function(Table $table) {
    $table->integer("id", "UNSIGNED AUTO_INCREMENT PRIMARY KEY");
    $table->string("name");
    return $table;
})

?>