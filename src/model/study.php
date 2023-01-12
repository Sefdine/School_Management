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
            'SELECT nom FROM filiere ORDER BY nom ASC'
        );
        $studies = [];
        while($row = $statement->fetch()) {
            $studies[] = $row['nom'];
        }
        return $studies;
    }

    public function getIdStudy(string $name, int $id_year): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM filiere WHERE nom = ? AND id_annee = ?'
        );
        $statement->execute([$name, $id_year]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}