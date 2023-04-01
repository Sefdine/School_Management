<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Admin extends User
{
    public $name;
    public $slug;
    use Contain, Module, Registration, Exam;
    public function insertUserStudent(array $data, string $password, string $token):bool {
        $connection = new Database;
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $identifier = $data['identifier'] ?? '';
        $nationality = $data['nationality'] ?? '';
        $birthday = $data['birthday'] ?? '';
        $address = $data['address'] ?? '';
        $cin = $data['cin'] ?? '';
        $place_birth = $data['place_birth'] ?? '';
        $registration_date = $data['registration_date'] ?? '';
        $gender = $data['gender'] ?? '';
        $level_study = $data['level_study'] ?? '';
        $entry_date = $data['entry_date'] ?? '';


        $connection->getConnection()->beginTransaction();

        $insertUserStatement = $connection->getConnection()->prepare('
            INSERT INTO users(
                firstname, 
                lastname, 
                identifier, 
                password, 
                token, 
                cin, 
                address
            )
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
            INSERT INTO students(
                nationality, 
                date_of_birth, 
                user_id,
                place_birth,
                registration_date,
                gender,
                level_study,
                entry_date
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ');
        $result = $insertStudentStatement->execute([
            $nationality, 
            $birthday, 
            $user_id,
            $place_birth,
            $registration_date,
            $gender,
            $level_study,
            $entry_date
        ]);     

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
        $email = strtolower($data['email']) ?? '';
        $tel = $data['tel'];
        $cin = $data['cin'];
        $address = $data['address'];
        $degree = $data['degree'];
        $experience = $data['experience'];

        $connection->getConnection()->beginTransaction();

        $insertUserStatement = $connection->getConnection()->prepare('
            INSERT INTO users(firstname, lastname, cin, address)
            VALUES (?, ?, ?, ?)
        ');
        
        $insertUserStatement->execute([
            $firstname,
            $lastname,
            $cin,
            $address
        ]);
        $user_id = $connection->getConnection()->lastInsertId('id');
        $insertStudentStatement = $connection->getConnection()->prepare('
            INSERT INTO teachers(email, tel, user_id, degree, experience)
            VALUES (?, ?, ?, ?, ?)
        ');
        $result = $insertStudentStatement->execute([$email, $tel, $user_id, $degree, $experience]);     

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
            SELECT DISTINCT g.name as groupe, g.slug FROM groupes g
            JOIN contain c ON g.id = c.group_id
            JOIN years y ON y.id = c.year_id
            JOIN studies s ON s.id = c.study_id
            WHERE y.name = ?
            AND s.name = ?
        ');
        $groupes = [];
        $statement->execute([$year, $study]);
        while ($row = $statement->fetch()) {
            $group = new self;
            $group->name = $row['groupe'];
            $group->slug = $row['slug'];
            $groupes[] = $group;
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
            AND g.slug = ?
        ');
        $groupes = [];
        $statement->execute([$year, $study, $group]);
        while ($row = $statement->fetch()) {
            $groupes[] = $row['level'];
        }
        return $groupes;
    }
}