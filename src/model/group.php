<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Group
{
    public $name;
    public $slug;

    public function getGroups(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT name, slug FROM groupes ORDER BY name ASC'
        );
        $groups = [];
        while($row = $statement->fetch()) {
            $group = new Self;
            $group->name = $row['name'];
            $group->slug = $row['slug'];
            $groups[] = $group;
        }
        return $groups;
    }

    public function getIdGroup(string $group_slug): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM groupes WHERE slug = ?'
        );
        $statement->execute([$group_slug]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }

    public function getGroup(string $slug): string
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT name FROM groupes WHERE slug = ?'
        );
        $statement->execute([$slug]);
        return ($row = $statement->fetch()) ? $row['name'] : '';
    }
}