<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;
use PDOException;

class Admin extends User
{
    public $name;
    public $slug;
    public $cin;
    public $address;
    public $nationality;
    public $date_of_birth;
    public $registration_date;
    public $entry_date;
    public $place_birth;
    public $gender;
    public $level_study;
    public $status;
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
    public function getListStudents(string $year, string $study, int $group, int $offset): array {
        $conn = new Database;
        $stmt = $conn->getConnection()->prepare('
            SELECT firstname, lastname, identifier FROM users u 
            JOIN students s ON u.id = s.user_id
            join registrations r ON s.id = r.student_id
            WHERE r.year_id = (SELECT id FROM years WHERE name = ?)
            AND r.study_id = (SELECT id FROM studies WHERE name = ?)
            AND r.group_id = (SELECT id FROM groupes WHERE group_number = ?)
            AND s.status = 1
            LIMIT 10
            OFFSET ?
        ');
        $stmt->execute([$year, $study, $group, $offset]);
        $data = [];
        while ($row = $stmt->fetch()) {
            $line = new self;
            $line->firstname = $row['firstname'];
            $line->lastname = $row['lastname'];
            $line->identifier = $row['identifier'];
            $data[] = $line;
        }
        return $data;
    }
    public function getInfoStudent(string $identifier): self {
        $conn = new Database;
        $stmt = $conn->getConnection()->prepare('
        SELECT 
            firstname, 
            lastname, 
            identifier, 
            cin, 
            address, 
            nationality, 
            date_of_birth, 
            s.registration_date, 
            entry_date, 
            place_birth, 
            gender, 
            level_study, 
            status
        FROM users u 
        JOIN students s ON u.id = s.user_id
        WHERE TRIM(u.identifier) = ?
        ');
        $stmt->execute([$identifier]);
        $row = $stmt->fetch();
        $item = new self;
        $item->firstname = $row['firstname'];
        $item->lastname = $row['lastname'];
        $item->identifier = $row['identifier'];
        $item->cin = $row['cin'];
        $item->address = $row['address'];
        $item->nationality = $row['nationality'];
        $item->date_of_birth = $row['date_of_birth'];
        $item->registration_date = $row['registration_date'];
        $item->entry_date = $row['entry_date'];
        $item->place_birth = $row['place_birth'];
        $item->gender = $row['gender'];
        $item->level_study = $row['level_study'];
        $item->status = $row['status'];
        return $item;
    }
    public function getTotalInscrit(string $year, string $study, int $group): int {
        $conn = new Database;
        $stmt = $conn->getConnection()->prepare('
            SELECT COUNT(u.id) as total FROM users u 
            JOIN students s ON u.id = s.user_id     
            JOIN registrations r ON s.id = r.student_id
            JOIN years y ON y.id = r.year_id
            JOIN studies st ON st.id = r.study_id
            JOIN groupes gp ON gp.id = r.group_id
            WHERE y.name = ?
            AND st.name = ?
            AND gp.group_number = ?
            AND s.status = 1;
        ');
        $stmt->execute([$year, $study, $group]);
        $row = $stmt->fetch();
        return $row['total'];
    }
}
