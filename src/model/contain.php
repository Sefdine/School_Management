<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Contain
{
    use Year, Study, Group, Level;

    public function getIdContain(int $year_id, int $study_id, int $group_id, int $level_id): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM contain WHERE
            year_id = ? AND
            study_id = ? AND 
            group_id = ? AND 
            level_id = ?'
        );
        $statement->execute([$year_id, $study_id, $group_id, $level_id]);
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}