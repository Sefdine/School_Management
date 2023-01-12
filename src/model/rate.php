<?php

declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Rate 
{
    public int $id;
    public string $firstname;
    public string $lastname;
    public float $value_rate;
    public string $name_module;

    public function updateRate(int $identifier, $value): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'UPDATE note SET valeur = ? WHERE id = ?'
        );
        $affectedLines = $statement->execute([$value, $identifier]);
        return ($affectedLines > 0);
    }

    public function insertRate(float $value, int $id_inscription, int $id_module, int $id_control, int $id_year): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'INSERT INTO 
            note
            (
                valeur, 
                id_inscription, 
                id_module, 
                id_controle, 
                id_annee
            )
            VALUES(
                ?,
                (SELECT id_etudiant FROM inscription WHERE id_etudiant = ?),
                (SELECT id FROM module WHERE id = ?),
                (SELECT id FROM controle WHERE id = ?),
                (SELECT id FROM annee WHERE id = ?)
            )'
        );
        $affectedLines = $statement->execute([$value, $id_inscription, $id_module, $id_control, $id_year]);
        return ($affectedLines > 0);
    }

    public function getRates(int $identifier, int $control, string $year): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT n.valeur, m.nom
            FROM note n,
            module m,
            annee a,
            filiere f,
            groupe g,
            niveau ni,
            controle c
            WHERE a.id = f.id_annee
            AND f.id = g.id_filiere
            AND g.id = ni.id_groupe
            AND ni.id = m.id_niveau
            AND m.id = n.id_module
            AND n.id_controle = c.id
            AND n.id_annee = a.id
            AND a.annee = ?
            AND c.id = ?
            AND n.id_inscription = ?'
        );
        $statement->execute([$year, $control, $identifier]);
        $rates = [];
        while($row = $statement->fetch()) {
            $rates[$row['nom']] = $row['valeur'];
        }
        return $rates;
    }

    public function checkRateIfExist(string $identifier, string $year, string $study, string $group, string $level, string $control, string $module): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT n.id FROM 
            note n, 
            annee a,
            filiere f,
            groupe g,
            niveau ni,
            module m,
            inscription i,
            controle c
            WHERE 
            n.id_annee = a.id
            AND n.id_module = m.id
            AND n.id_controle = c.id
            AND n.id_inscription = i.id_etudiant
            AND i.id_niveau = ni.id
            AND m.id_niveau = ni.id
            AND ni.id_groupe = g.id
            AND g.id_filiere = f.id
            AND f.id_annee = a.id
            AND f.nom = ?
            AND g.nom = ?
            AND a.annee = ?
            AND c.id = ?
            AND m.nom = ?
            AND ni.niveau = ?
            AND i.identifiant = ?'
        );
        $statement->execute([
            $study, 
            $group, 
            $year, 
            $control, 
            $module, 
            $level, 
            $identifier
        ]);
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
    }
}