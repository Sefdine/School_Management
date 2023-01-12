<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Module
{
    public function getModules(string $identifier, string $level, string $group): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT m.nom 
            FROM module m, enseigner en, niveau n, groupe g
            WHERE m.id = en.id_module 
            AND m.id_niveau = n.id
            AND n.id_groupe = g.id
            AND en.id_enseignant = ?
            AND n.niveau = ?
            AND g.nom = ?'
        );
        $statement->execute([$identifier, $level, $group]);
        $modules = [];
        while($row = $statement->fetch()) {
            $modules[] = $row['nom'];
        }

        return $modules;
    }

    public function getIdModule(string $name, int $id_level): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM module WHERE nom = ? AND id_niveau = ?'
        );
        $statement->execute([$name, $id_level]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}