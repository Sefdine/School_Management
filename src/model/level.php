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
            'SELECT niveau FROM niveau WHERE id_groupe = ?'
        );
        $statement->execute([$identifier]);
        $levels = [];
        while($row = $statement->fetch()) {
            $levels[] = $row['niveau'];
        }
        return $levels;
    }

    public function getIdLevel(string $level, int $id_group): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM niveau WHERE niveau = ? AND id_groupe = ?'
        );
        $statement->execute([$level, $id_group]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}