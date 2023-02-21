<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Exam
{
    public function getExams(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT number FROM exams ORDER BY number ASC'
        );
        $controls = [];
        while($row = $statement->fetch()) {
            $controls[] = $row['number'];
        }
        return $controls;
    }

    public function getIdExam(string $number): int 
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM exams WHERE number = ?'
        );
        $statement->execute([$number]);
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}