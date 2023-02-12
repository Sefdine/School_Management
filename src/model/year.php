<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Year
{
    public function getYears(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT name FROM years ORDER BY id ASC'
        );
        $years = [];
        while($row = $statement->fetch()) {
            $years[] = $row['name'];
        }
        return $years;
    }

    public function getIdYear(string $year): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM years WHERE name = ?'
        );
        $statement->execute([$year]);
    
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}