<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Student extends User
{
    use Inscription, Module, Year, Control;

    public function getData(string $year, int $identifier): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT f.nom, g.nom as groupe, n.niveau, i.identifiant
            FROM filiere f, groupe g, niveau n, annee a, inscription i
            WHERE a.id = f.id_annee
            AND f.id = g.id_filiere
            AND g.id = n.id_groupe
            AND n.id = i.id_niveau
            AND a.annee = ?
            AND i.id_etudiant = ?'
        );
        $statement->execute([$year, $identifier]);

        if($row = $statement->fetch()) {
            $data['study'] = $row['nom'];
            $data['group'] = $row['groupe'];
            $data['level'] = $row['niveau'];
            $data['num_inscription'] = $row['identifiant'];

            return $data;
        } else {
            header('Location: index.php?action=landing&id='.$identifier.'&error=rate_not_exist');
            die();
        }
    }
}