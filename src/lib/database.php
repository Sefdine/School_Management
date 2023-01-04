<?php

declare(strict_types=1);

namespace Ipem\Src\Lib;

class Database
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host=localhost;dbname=ipem;charset=utf8', 'root', 'root');
        }
        return $this->database;
    }
}