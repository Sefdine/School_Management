<?php
declare(strict_types=1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

class Student extends User
{
    public function getId(string $value): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM etudiant WHERE identifier = ?'
        );
        $statement->execute([$value]);
        if ($row = $statement->fetch()) {
            $identifier = $row['id'];
            return $identifier;
        } else {
            return 0;
        }
    }
}