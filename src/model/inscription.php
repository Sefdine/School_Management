<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Inscription
{
    public function getIdInscription(string $identifier, int $id_level): int 
    {
        $connecton = new Database;
        $statement = $connecton->getConnection()->prepare(
            'SELECT id_etudiant FROM inscription WHERE identifiant = ? AND id_niveau = ?'
        );
        $statement->execute([$identifier, $id_level]);
        
        return ($row = $statement->fetch()) ? $row['id_etudiant'] : 0;
    }
}