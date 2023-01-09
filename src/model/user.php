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
                'SELECT u.id, password, token, identifiant FROM utilisateur u, inscription i, etudiant e WHERE i.id_etudiant = e.id AND e.id = u.id ORDER BY u.id ASC'
            );
        } elseif($name === 'teacher') {
            $statement = $connection->getConnection()->query(
                'SELECT u.id, password, token, identifiant FROM utilisateur u, enseignant e WHERE u.id = e.id ORDER BY u.id ASC'
            );
        }
        
        $users = [];
        while($row = $statement->fetch()) {
            $user = new self;
            $user->id = $row['id'];
            $user->identifier = $row['identifiant'];
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
                'SELECT u.id, nom, prenom, password, identifiant FROM inscription i, etudiant e, utilisateur u WHERE i.id_etudiant = e.id AND e.id = u.id AND u.id = ?'
            );
        } elseif ($name === 'teacher') {
            $statement = $connection->getConnection()->prepare(
                'SELECT u.id, nom, prenom, password, identifiant FROM  enseignant e, utilisateur u WHERE e.id = u.id AND u.id = ?'
            );
        }
        
        $statement->execute([$identifier]);
        $row = $statement->fetch();
        $user = new self;
        $user->id = $row['id'];
        $user->firstname = $row['nom'];
        $user->lastname = $row['prenom'];
        $user->identifier = $row['identifiant'];
        $user->password = $row['password'];

        return $user;
    }

    public function setPassword(string $identifier, string $new_password): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'UPDATE utilisateur SET password = ? WHERE id = ?'
        );    

        $affectedLines = $statement->execute([$new_password, $identifier]);
        return ($affectedLines > 0);
    }
}

