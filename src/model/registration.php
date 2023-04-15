<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Registration
{
    public function getIdRegistration(int $student_id, int $year_id, int $study_id, int $group_id): int 
    {
        $connecton = new Database;
        $statement = $connecton->getConnection()->prepare('
            SELECT id FROM registrations WHERE student_id = ? 
            AND year_id = ?
            AND study_id = ?
            AND group_id = ?
        ');
        $statement->execute([
            $student_id, 
            $year_id,
            $study_id,
            $group_id
        ]);
        
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}