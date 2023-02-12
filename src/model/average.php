<?php

declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Average 
{
    public int $id;
    public string $firstname;
    public string $lastname;
    public float $value_average;
    public string $name_module;

    public function updateAverage(int $identifier, $value): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'UPDATE averages SET value = ? WHERE id = ?'
        );
        $affectedLines = $statement->execute([$value, $identifier]);
        return ($affectedLines > 0);
    }

    public function insertAverage(float $value, int $id_inscription, int $id_module, int $id_control, int $id_year): bool
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'INSERT INTO 
            averages (value, exam_id, module_id)
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

    public function getAverages(int $identifier, int $control, string $year): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT m.name, a.value
            FROM averages a 
            JOIN registrations r ON r.id = a.registration_id
            JOIN modules m ON m.id = a.module_id
            JOIN exams e ON e.id = a.exam_id
            JOIN contain c ON c.id = r.contain_id
            JOIN years y ON y.id = c.year_id
            JOIN students s ON s.id = r.student_id
            JOIN users u ON u.id = s.user_id
            AND y.name = ?
            AND e.number = ?
            AND u.id = ?'
        );
        $statement->execute([$year, $control, $identifier]);
        $averages = [];
        while($row = $statement->fetch()) {
            $averages[$row['name']] = $row['value'];
        }
        return $averages;
    }

    public function checkAverageIfExist(string $identifier, string $year, string $study, string $group, string $level, string $control, string $module): int
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