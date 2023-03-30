<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Admin extends User
{
    use Year, Module, Group;
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
        $user_id = $connection->getConnection()->lastInsertId('id');
        $insertStudentStatement = $connection->getConnection()->prepare('
            INSERT INTO students(nationality, date_of_birth, user_id)
            VALUES (?, ?, ?)
        ');
        $result = $insertStudentStatement->execute([$nationality, (string)$birthday, $user_id]);     

        if($result) {
            $connection->getConnection()->commit();
            return true;
        } else {
            $connection->getConnection()->rollBack();
            return false;
        }
    }
    public function insertUserTeacher(array $data):bool {
        $connection = new Database;
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $email = $data['email'] ?? '';
        $tel = $data['tel'];
        $cin = $data['cin'];
        $address = $data['address'];

        $connection->getConnection()->beginTransaction();

        $insertUserStatement = $connection->getConnection()->prepare('
            INSERT INTO users(firstname, lastname, identifier, password, token, cin, address)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ');
        
        $insertUserStatement->execute([
            $firstname,
            $lastname,
            '',
            '',
            '',
            $cin,
            $address
        ]);
        $user_id = $connection->getConnection()->lastInsertId('id');
        $insertStudentStatement = $connection->getConnection()->prepare('
            INSERT INTO teachers(email, tel, user_id)
            VALUES (?, ?, ?)
        ');
        $result = $insertStudentStatement->execute([$email, $tel, $user_id]);     

        if($result) {
            $connection->getConnection()->commit();
            return true;
        } else {
            $connection->getConnection()->rollBack();
            return false;
        }
    }
    public function insertStudy(string $name): bool {
        $connection = new Database;
        $connection->getConnection()->beginTransaction();
        $statement = $connection->getConnection()->prepare("
            INSERT INTO studies SET name = ?
        ");
        $result = $statement->execute([$name]);
        if ($result) {
            $connection->getConnection()->commit();
            return true;
        } else {
            $connection->getConnection()->rollBack();
            return false;
        }
    }
    public function insertGroup(string $name, string $slug): bool {
        $connection = new Database;
        $connection->getConnection()->beginTransaction();
        $statement = $connection->getConnection()->prepare("
            INSERT INTO groupes(name, slug) VALUES(?, ?)
        ");
        $result = $statement->execute([$name, $slug]);
        if ($result) {
            $connection->getConnection()->commit();
            return true;
        } else {
            $connection->getConnection()->rollBack();
            return false;
        }
    }
    public function getStudies(string $year): array {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT DISTINCT s.name AS study FROM studies s
            JOIN contain c ON s.id = c.study_id
            JOIN years y ON y.id = c.year_id
            WHERE y.name = ?
        ');
        $statement->execute([$year]);
        $studies = [];
        while($row = $statement->fetch()) {
            $studies[] = $row['study'];
        }
        return $studies;
    }
    public function getGroups(string $year, string $study) {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT DISTINCT g.name as groupe FROM groupes g
            JOIN contain c ON g.id = c.group_id
            JOIN years y ON y.id = c.year_id
            JOIN studies s ON s.id = c.study_id
            WHERE y.name = ?
            AND s.name = ?
        ');
        $groupes = [];
        $statement->execute([$year, $study]);
        while ($row = $statement->fetch()) {
            $groupes[] = $row['groupe'];
        }
        return $groupes;
    }
    public function getLevels(string $year, string $study, string $group) {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT level FROM levels l
            JOIN contain c ON l.id = c.level_id
            JOIN years y ON y.id = c.year_id
            JOIN studies s ON s.id = c.study_id
            JOIN groupes g ON g.id = c.group_id
            WHERE y.name = ?
            AND s.name = ?
            AND g.name = ?
        ');
        $groupes = [];
        $statement->execute([$year, $study, $group]);
        while ($row = $statement->fetch()) {
            $groupes[] = $row['level'];
        }
        return $groupes;
    }
}