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

    public function getIdStudy(string $name, int $id_year): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT s.id FROM studies s
            JOIN contain c ON s.id = c.study_id
            JOIN years y ON c.year_id = y.id 
            WHERE s.name = ? AND y.id = ?'
        );
        $statement->execute([$name, $id_year]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}