<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Level
{
    public function getlevels(string $identifier): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT level FROM levels l
            JOIN contain c ON l.id = c.level_id
            AND c.group_id = ?'
        );
        $statement->execute([$identifier]);
        $levels = [];
        while($row = $statement->fetch()) {
            $levels[] = $row['level'];
        }
        return $levels;
    }

    public function getIdLevel(string $level): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM levels WHERE level = ?'
        );
        $statement->execute([$level]);
        
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}