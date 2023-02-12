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
            'SELECT level FROM levels WHERE group_id = ?'
        );
        $statement->execute([$identifier]);
        $levels = [];
        while($row = $statement->fetch()) {
            $levels[] = $row['level'];
        }
        return $levels;
    }

    public function getIdLevel(string $level, int $id_group): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM levels WHERE level = ? AND group_id = ?'
        );
        $statement->execute([$level, $id_group]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}