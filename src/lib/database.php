<?php

declare(strict_types=1);

namespace Ipem\Src\Lib;

class Database
{
    public $database;
    private $dbhost = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    public function getConnection(): \PDO
    {
        try{
            if (!$this->database) {
                $this->database = new \PDO(
                    'mysql:host='.$this->dbhost.
                    ';dbname='.$this->dbname.
                    ';charset=utf8;', 
                    $this->user, 
                    $this->pass,
                    [
                        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_WARNING,
                        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                        \PDO::ATTR_EMULATE_PREPARES => false,
                        \PDO::ATTR_AUTOCOMMIT => true,
                        \PDO::MYSQL_ATTR_FOUND_ROWS => true
                    ]
                );
            }  
        } catch(\PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $this->database;
    }
} 

