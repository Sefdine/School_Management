<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Registration
{
    public function getIdRegistration(string $identifier, int $id_level): int 
    {
        $connecton = new Database;
        $statement = $connecton->getConnection()->prepare(
            'SELECT s.id AS studentId FROM students s
            JOIN users u ON u.id = s.user_id
            JOIN registrations r ON s.id = r.student_id
            JOIN contain c ON c.id = r.contain_id
            AND u.identifier = ?
            AND c.level_id = ?'
        );
        $statement->execute([$identifier, $id_level]);
        
        return ($row = $statement->fetch()) ? $row['studentId'] : 0;
    }
}