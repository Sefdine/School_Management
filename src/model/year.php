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
            'SELECT annee FROM annee ORDER BY id ASC'
        );
        while($row = $statement->fetch()) {
            $years[] = $row['annee'];
        }
        return $years;
    }

    public function getIdYear(string $year): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM annee WHERE annee = ?'
        );
        $statement->execute([$year]);
    
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}