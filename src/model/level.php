<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Level
{
    public function getlevels(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT level FROM levels'
        );
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