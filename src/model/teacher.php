<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Teacher extends User
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

    public function getlevels(string $identifier): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT niveau FROM niveau WHERE id_groupe = ?'
        );
        $statement->execute([$identifier]);
        $levels = [];
        while($row = $statement->fetch()) {
            $levels[] = $row['niveau'];
        }
        return $levels;
    }

    public function getControls(): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->query(
            'SELECT id FROM controle ORDER BY id ASC'
        );
        $controls = [];
        while($row = $statement->fetch()) {
            $controls[] = $row['id'];
        }
        return $controls;
    }
}