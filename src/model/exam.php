<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Exam
{
    public function getControls(): array
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
}