<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Study
{
    public function getStudies(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT name FROM studies ORDER BY name ASC'
        );
        $studies = [];
        while($row = $statement->fetch()) {
            $studies[] = $row['name'];
        }
        return $studies;
    }

    public function getIdStudy(string $name): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM studies WHERE name = ?'
        );
        $statement->execute([$name]);
        
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
}