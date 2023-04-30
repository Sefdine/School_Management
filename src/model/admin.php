<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;
use PDOException;

class Admin extends User
{
    public $name;
    public $slug;
    use Module, Registration, Exam, Year, Study, Group;
    public function insertUserStudent(array $data, string $password, string $token, string $year, string $study, int $group):bool {
        $connection = new Database;
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $identifier = $data['identifier'] ?? null;
        $nationality = $data['nationality'] ?? '';
        $birthday = $data['birthday'] ?? '';
        $address = $data['address'] ?? '';
        $cin = $data['cin'] ?? '';
        $place_birth = $data['place_birth'] ?? '';
        $registration_date = $data['registration_date'] ?? '';
        $gender = $data['gender'] ?? '';
        $level_study = $data['level_study'] ?? '';
        $entry_date = $data['entry_date'] ?? '';

        $year_id = self::getIdYear($year);
        $study_id = self::getIdStudy($study);
        $group_id = self::getIdGroup($group);

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
        $user_id = $connection->getConnection()->lastInsertId();

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
        $insertStudentStatement->execute([
            $nationality, 
            $birthday, 
            $user_id,
            $place_birth,
            $registration_date,
            $gender,
            $level_study,
            $entry_date
        ]);     
        $student_id = $connection->getConnection()->lastInsertId();
        $insertRegistrationStatement = $connection->getConnection()->prepare('
            INSERT INTO registrations(student_id, year_id, study_id, group_id)
            VALUES (?, ?, ?, ?)
        ');
        $result = $insertRegistrationStatement->execute([$student_id, $year_id, $study_id, $group_id]);

    
        if($result) {
            $connection->getConnection()->commit();
            return true;
        } else {
            $connection->getConnection()->rollBack();
            return false;
        }
    }
    public function insertUserTeacher(array $data, array $modules, string $year, $study, $group):bool {
        $connection = new Database;
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $email = strtolower($data['email']) ?? '';
        $tel = $data['tel'];
        $cin = $data['cin'];
        $address = $data['address'];
        $degree = $data['degree'];
        $experience = ($data['experience']) ? $data['experience'] : 0;
        $count = 0;

        $year_id = self::getIdYear($year);
        $study_id = self::getIdStudy($study);
        $group_id = self::getIdGroup($group);

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
        $user_id = $connection->getConnection()->lastInsertId();

        $insertTeacherStatement = $connection->getConnection()->prepare('
            INSERT INTO teachers(email, tel, user_id, degree, experience)
            VALUES (?, ?, ?, ?, ?)
        ');
        $insertTeacherStatement->execute([$email, $tel, $user_id, $degree, $experience]);     
        $teacher_id = $connection->getConnection()->lastInsertId();

        foreach($modules as $module) {
            $module_id = self::getIdModule($module);
            $insertTeachStmt = $connection->getConnection()->prepare('
                INSERT INTO teachs (teacher_id, group_id, study_id, year_id, module_id)
                VALUES (?, ?, ?, ?, ?)
            ');
            $result = $insertTeachStmt->execute([$teacher_id, $group_id, $study_id, $year_id, $module_id]);
            if ($result) {
                $count++;
            }
        }

        if($count == count($modules)) {
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
    public function getStudies(string $year): array {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT DISTINCT s.name AS study FROM studies s
            JOIN years_studies ys ON s.id = ys.study_id
            JOIN years y ON y.id = ys.year_id
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
            SELECT DISTINCT group_number FROM groupes g
            JOIN studies_groupes sg ON g.id = sg.group_id
            JOIN studies s ON s.id = sg.study_id
            JOIN years_studies ys ON s.id = ys.study_id
            JOIN years y ON y.id = ys.year_id
            WHERE y.name = ?
            AND s.name = ?
        ');
        $groupes = [];
        $statement->execute([$year, $study]);
        while ($row = $statement->fetch()) {
            $groupes[] = $row['group_number'];
        }
        return $groupes;
    }
    public function getFirstnameLastname(string $year, string $study, int $group): array {
        $conn = new Database;
        $stmt = $conn->getConnection()->prepare('
            SELECT firstname, lastname FROM users u 
            JOIN students s ON u.id = s.user_id
            join registrations r ON s.id = r.student_id
            WHERE r.year_id = (SELECT id FROM years WHERE name = ?)
            AND r.study_id = (SELECT id FROM studies WHERE name = ?)
            AND r.group_id = (SELECT id FROM groupes WHERE group_number = ?)
        ');
        $stmt->execute([$year, $study, $group]);
        $data = [];
        while ($row = $stmt->fetch()) {
            $line = new self;
            $line->firstname = $row['firstname'];
            $line->lastname = $row['lastname'];
            $data[] = $line;
        }
        return $data;
    }
}


$element = new Admin;
if ($action == 'year') {
    if (isset($_POST['year'])) {
        $year = $_POST['year'];
        $response = $element->getStudies($year);
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
