<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Student extends User
{
    use Registration, Module, Year, Exam;

    public function getDataStudent(string $year, int $exam, int $identifier): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT DISTINCT s.name AS study, g.name AS groupe, l.level, u.identifier
                FROM contain c
                JOIN studies s ON c.study_id = s.id
                JOIN groupes g ON c.group_id = g.id
                JOIN levels l ON c.level_id = l.id
                JOIN years y ON c.year_id = y.id
                JOIN registrations r ON c.id = r.contain_id
                JOIN averages a ON r.id = a.registration_id
                JOIN exams e ON e.id = a.exam_id
                JOIN students st ON r.student_id = st.id
                JOIN users u ON st.user_id = u.id
                WHERE y.name = ?
                AND e.number = ?
                AND u.id = ?'
        );
        $statement->execute([$year, $exam, $identifier]);

        if($row = $statement->fetch()) {
            $data['study'] = $row['study'];
            $data['group'] = $row['groupe'];
            $data['level'] = $row['level'];
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