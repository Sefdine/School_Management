<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Exam
{
    public function getExams(string $exam_type): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT exam_name FROM exams 
            WHERE exam_type_id = (SELECT id FROM exams_types WHERE exam_type = ?)
        ');
        $statement->execute([$exam_type]);
        $controls = [];
        while($row = $statement->fetch()) {
            $controls[] = $row['exam_name'];
        }
        return $controls;
    }

    public function getIdExam(string $exam_name): int 
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM exams WHERE exam_name = ?'
        );
        $statement->execute([$exam_name]);
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }

    public function getExamsTypes(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT exam_type FROM exams_types ORDER BY id ASC'
        );
        $controls = [];
        while($row = $statement->fetch()) {
            $controls[] = $row['exam_type'];
        }
        return $controls;
    }

    public function getIdExamType(string $exam_type): int 
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM exams_types WHERE exam_type = ?'
        );
        $statement->execute([$exam_type]);
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }    
}