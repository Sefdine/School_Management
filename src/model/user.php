<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class User 
{
    public Database $connection;
    
    public int $id;
    public string $identifier;
    public string $password;
    public string $firstname;
    public string $lastname;
    public string $token;

    public function getUsers(string $name): array
    {
        $connection = new Database;
        if ($name === 'student') {
            $statement = $connection->getConnection()->query(
                'SELECT id, identifier, password, token FROM student ORDER BY id ASC'
            );
        } elseif($name === 'teacher') {
            $statement = $connection->getConnection()->query(
                'SELECT id, identifier, password, token FROM teacher ORDER BY id ASC'
            );
        }
        
        $users = [];
        while($row = $statement->fetch()) {
            $user = new self;
            $user->id = $row['id'];
            $user->identifier = $row['identifier'];
            $user->password = $row['password'];
            $user->token = $row['token'];
            $users[] = $user;
        }
        return $users;
    }

    public function getuser(string $name, string $identifier): self
    {
        $connection = new Database;
        if ($name === 'student') {
            $statement = $connection->getConnection()->prepare(
                'SELECT * FROM student WHERE id = ?'
            );
        } elseif ($name === 'teacher') {
            $statement = $connection->getConnection()->prepare(
                'SELECT * FROM teacher WHERE id = ?'
            );
        }
        
        $statement->execute([$identifier]);
        $row = $statement->fetch();
        $user = new self;
        $user->id = $row['id'];
        $user->firstname = $row['firstname'];
        $user->lastname = $row['lastname'];
        $user->identifier = $row['identifier'];
        $user->password = $row['password'];

        return $user;
    }

    public function setPassword(string $name, string $identifier, string $new_password): bool
    {
        $connection = new Database;
        if ($name === 'student') {
            $statement = $connection->getConnection()->prepare(
                'UPDATE student SET password = ? WHERE id = ?'
            );    
        } elseif ($name === 'teacher') {
            $statement = $connection->getConnection()->prepare(
                'UPDATE teacher SET password = ? WHERE id = ?'
            );    
        }
        
        $affectedLines = $statement->execute([$new_password, $identifier]);
        return ($affectedLines > 0);
    }
}

