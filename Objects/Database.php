<?php


namespace Core\Objects;
use \PDO;

class Database {
    protected $PDO;
    private $table;
    function __construct($table) {
        $this->table = $table;
        $this->PDO = new PDO('mysql:host='.DB_HOST.';dbname='.DB_DB, DB_USER, DB_PW);
        
    }

    function __destruct() {
        $this->PDO = null;
    }



    function execute($query) {
        $res = null;
        try {
            $res = $this->PDO->query($query);
        } catch (PDOException $e) {
            print $e;
        }

        if (!$res) {
            die(var_export($this->PDO->errorinfo(), TRUE));
        }


        return $res->fetchAll();
    }

    


}