<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class User 
{
    public int $id;
    public string $identifier;
    public string $password;
    public string $firstname;
    public string $lastname;
    public string $token;

    public function getUsers(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT id, password, token, identifier
            FROM users 
            ORDER BY id ASC'
        );
        
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

    public function getUser(string $identifier): self
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id, firstname, lastname, password, identifier 
            FROM users
            WHERE id = ?'
        );
        
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

    public function setPassword(string $identifier, string $new_password): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'UPDATE users SET password = ? WHERE id = ?'
        );    

        $affectedLines = $statement->execute([$new_password, $identifier]);
        return ($affectedLines > 0);
    }
}

