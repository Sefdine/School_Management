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
            'SELECT modules FROM teacher WHERE id = ?'
        );
        $statement->execute([$identifier]);
        $row = $statement->fetch();
        $modules = explode(',', $row['modules']);

        return $modules;
    }
}