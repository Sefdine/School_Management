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
            'SELECT name FROM groupes ORDER BY name ASC'
        );
        $groups = [];
        while($row = $statement->fetch()) {
            $groups[] = $row['name'];
        }
        return $groups;
    }

    public function getIdGroup(string $name, int $id_study): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM groupes WHERE name = ? AND study_id = ?'
        );
        $statement->execute([$name, $id_study]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}