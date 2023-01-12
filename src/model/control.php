<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Control
{
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