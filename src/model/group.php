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
            'SELECT nom FROM groupe ORDER BY nom ASC'
        );
        $groups = [];
        while($row = $statement->fetch()) {
            $groups[] = $row['nom'];
        }
        return $groups;
    }

    public function getIdGroup(string $name, int $id_study): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM groupe WHERE nom = ? AND id_filiere = ?'
        );
        $statement->execute([$name, $id_study]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}