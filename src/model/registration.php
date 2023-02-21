<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Registration
{
    public function getIdRegistration(int $student_id, int $contain_id): int 
    {
        $connecton = new Database;
        $statement = $connecton->getConnection()->prepare(
            'SELECT id FROM registrations WHERE student_id = ? AND contain_id = ?'
        );
        $statement->execute([$student_id, $contain_id]);
        
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}