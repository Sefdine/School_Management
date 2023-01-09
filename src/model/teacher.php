<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Teacher extends User
{
    public function getModules(string $identifier): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT m.nom FROM module m, enseigner en, enseignant e, utilisateur u WHERE m.id = en.id_module AND en.id_enseignant = e.id AND e.id = u.id AND u.id = ?'
        );
        $statement->execute([$identifier]);
        while($row = $statement->fetch()) {
            $modules[] = $row['nom'];
        }

        return $modules;
    }
}