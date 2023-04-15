<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Group
{
    public function getGroups(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT group_number FROM groupes ORDER BY id ASC'
        );
        $groups = [];
        while($row = $statement->fetch()) {
            $groups[] = $row['group_number'];
        }
        return $groups;
    }

    public function getIdGroup(int $group): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM groupes WHERE group_number = ?'
        );
        $statement->execute([$group]);
        
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}