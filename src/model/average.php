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

    public function getAverages(int $identifier, int $control, string $year): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT m.name, a.value
            FROM averages a 
            JOIN registrations r ON r.id = a.registration_id
            JOIN modules m ON m.id = a.module_id
            JOIN exams e ON e.id = a.exam_id
            JOIN contain c ON c.id = r.contain_id
            JOIN years y ON y.id = c.year_id
            JOIN students s ON s.id = r.student_id
            JOIN users u ON u.id = s.user_id
            AND y.name = ?
            AND e.number = ?
            AND u.id = ?'
        );
        $statement->execute([$year, $control, $identifier]);
        $averages = [];
        while($row = $statement->fetch()) {
            $averages[$row['name']] = $row['value'];
        }
        return $averages;
    }

    public function insertAverage(float $value, int $registration_id, int $module_id, int $exam_id): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'INSERT INTO averages
            SET value = ?,
            registration_id = ?,
            exam_id = ?,
            module_id = ?
            ON DUPLICATE KEY UPDATE value = ?'
        );
        $affectedLines = $statement->execute([$value, $registration_id, $exam_id, $module_id, $value]);
        return ($affectedLines > 0);
    }
}