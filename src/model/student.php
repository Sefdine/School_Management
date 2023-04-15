<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Student extends User
{
    use Registration, Module, Year, Exam;

    public function getDataStudent(string $year, string $exam_name, string $exam_type, int $identifier): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT DISTINCT st.name AS study, g.group_number AS groupe, u.identifier
            FROM registrations r 
            JOIN studies st ON st.id = r.study_id
            JOIN groupes g ON g.id = r.group_id
            JOIN students s ON s.id = r.student_id
            JOIN users u ON u.id = s.user_id
            JOIN years y ON y.id = r.year_id
            JOIN averages a ON r.id = a.registration_id
            JOIN exams e ON e.id = a.exam_id
            WHERE y.name = ?
            AND e.exam_name = ?
            AND e.exam_type_id = (SELECT id FROM exams_types WHERE exam_type = ?)
            AND u.id = ?
        ');
        $statement->execute([$year, $exam_name, $exam_type, $identifier]);

        if($row = $statement->fetch()) {
            $data['study'] = $row['study'];
            $data['group'] = $row['groupe'];
            $data['num_inscription'] = $row['identifier'];

            return $data;
        } else {
            $_SESSION['err'] = 'rate_not_exist';
            header('Location: '. URL_ROOT .'landing');
            die();
        }
    }

    public function getIdStudent(int $user_id): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM students WHERE user_id = ?'
        );
        $statement->execute([$user_id]);
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}