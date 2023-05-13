<?php

declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Average 
{
    public $id;
    public $firstname;
    public $lastname;
    public $value_average;
    public $name_module;
    public $factor;
    public $controles;
    public $pratical;
    public $theorical;

    public function getAverages(int $identifier, string $exam_name, string $exam_type, string $year, string $study, int $group, ): array {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT m.name, a.value, sgm.factor
            FROM averages a 
            JOIN registrations r ON r.id = a.registration_id
            JOIN modules m ON m.id = a.module_id
            JOIN studies_groupes_modules sgm ON m.id = sgm.module_id
            JOIN exams e ON e.id = a.exam_id
            JOIN years y ON y.id = r.year_id
            JOIN students s ON s.id = r.student_id
            JOIN users u ON u.id = s.user_id
            WHERE sgm.study_id = (SELECT id FROM studies WHERE name = ?)
            AND sgm.group_id = (SELECT id FROM groupes WHERE group_number = ?)
            AND y.name = ?
            AND e.exam_name = ?
            AND e.exam_type_id = (SELECT id FROM exams_types WHERE exam_type = ?)
            AND u.id = ?
        ');
        $statement->execute([$study, $group, $year, $exam_name, $exam_type, $identifier]);
        $averages = [];
        while($row = $statement->fetch()) {
            $average = new self;
            $average->name_module = $row['name'];
            $average->value_average = $row['value'];
            $average->factor = $row['factor'];
            $averages[] = $average;
        }
        return $averages;
    }
    public function insertAverage(float $value, int $registration_id, int $module_id, int $exam_id): bool {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            INSERT INTO averages
            SET value = ?,
            registration_id = ?,
            exam_id = ?,
            module_id = ?
            ON DUPLICATE KEY UPDATE value = ?;
        ');
        $affectedLines = $statement->execute([$value, $registration_id, $exam_id, $module_id, $value]);
        return ($affectedLines > 0);
    }
    public function getTotalFactor(string $year, string $study, int $group): array {
        $conn = new Database;
        $stmt = $conn->getConnection()->prepare('
            SELECT COUNT(module_id) as total, SUM(factor) as factors FROM studies_groupes_modules sgm 
            JOIN studies s ON s.id = sgm.study_id
            JOIN groupes g ON g.id = sgm.group_id
            JOIN years_studies ys ON s.id = ys.study_id
            JOIN years y ON y.id = ys.year_id
            WHERE y.name = ?
            AND s.name = ?
            AND g.group_number = ?
        ');
        $stmt->execute([$year, $study, $group]);
        $row = $stmt->fetch();
        return [$row['total'], $row['factors']];
    }
    public function getDataReleveExam(string $year, string $study, int $group, string $identifier): array{
        $conn = new Database;
        $stmt = $conn->getConnection()->prepare("
            SELECT 
                m.name AS module, 
                sgm.factor AS coeff,
                AVG(CASE WHEN e.exam_name = 'CC1' THEN a.`value` WHEN e.exam_name = 'CC2' THEN a.`value` ELSE NULL END) AS controles,
                MAX(CASE WHEN e.exam_name = 'Examen théorique' THEN a.value ELSE NULL END) AS theorical,
                MAX(CASE WHEN e.exam_name = 'Examen pratique' THEN a.value ELSE NULL END) AS pratical
            FROM modules m 
            JOIN studies_groupes_modules sgm ON m.id = sgm.module_id
            JOIN studies s ON s.id = sgm.study_id
            JOIN groupes g ON g.id = sgm.group_id
            JOIN years_studies ys ON s.id = ys.study_id
            JOIN years y ON y.id = ys.year_id
            JOIN registrations r ON g.id = r.group_id AND s.id = r.study_id AND y.id = r.year_id
            JOIN averages a ON m.id = a.module_id AND a.registration_id = r.id
            JOIN exams e ON e.id = a.exam_id
            JOIN students st ON st.id = r.student_id
            JOIN users u ON u.id = st.user_id
            WHERE y.name = ?
            AND s.name = ?
            AND g.group_number = ?
            AND e.exam_name IN ('CC1', 'CC2', 'Examen théorique', 'Examen pratique')
            AND TRIM(u.identifier) = ?
            GROUP BY m.id, sgm.factor
        ");
        $stmt->execute([$year, $study, $group, trim($identifier)]);
        $data = [];
        while ($row = $stmt->fetch()) {
            $item = new self;
            $item->name_module = $row['module'];
            $item->factor = $row['coeff'];
            $item->controles = $row['controles'];
            $item->pratical = $row['pratical'];
            $item->theorical = $row['theorical'];
            $data[] = $item;
        }
        return $data;
    }
}