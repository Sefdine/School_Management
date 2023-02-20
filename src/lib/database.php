<?php

declare(strict_types=1);

namespace Ipem\Src\Lib;

class Database
{
    public ?\PDO $database = null;
    private $dbhost = DB_HOST;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            try{
                $this->database = new \PDO(
                    'mysql:host='.$this->dbhost.
                    ';dbname='.$this->dbname.
                    ';charset=utf8;', 
                    $this->user, 
                    $this->pass
                );
                $this->database->setAttribute(\PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }
        return $this->database;
    }
} 

