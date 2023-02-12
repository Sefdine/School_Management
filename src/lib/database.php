<?php

declare(strict_types=1);

namespace Ipem\Src\Lib;

class Database
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            try{
                $this->database = new \PDO(
                    'mysql:host=localhost;
                    dbname=ipem;
                    charset=utf8;
                    port=3306', 
                    'root', 
                    'root'
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

