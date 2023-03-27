<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Admin extends User
{
    public function insertUserStudent(array $data, string $password, string $token):bool {
        $connection = new Database;
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $identifier = $data['identifier'] ?? '';
        $nationality = $data['nationality'] ?? '';
        $birthday = $data['birthday'] ?? '';
        $address = $data['address'] ?? '';
        $cin = $data['cin'] ?? '';

        $connection->getConnection()->beginTransaction();
        $insertUserStatement = $connection->getConnection()->prepare('
            INSERT INTO users(firstname, lastname, identifier, password, token, cin, address)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        $insertUserStatement->execute([
            $firstname,
            $lastname,
            $identifier,
            $password,
            $token,
            $cin,
            $address
        ]);

        $user_id = $connection->getConnection()->lastInsertId();

        $insertStudentStatement = $connection->getConnection()->prepare('
            INSERT INTO students(nationality, date_of_birth, user_id)
            VALUES (?, ?, ?)
        ');
        $result = $insertStudentStatement->execute([$nationality, $birthday, $user_id]);

        if($result) {
            $connection->getConnection()->commit();
            return true;
        } else {
            $connection->getConnection()->rollBack();
            return false;
        }
    }
}