<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Module
{
    public $name;
    public $slug;

    public function getModules(int $group, string $study, string $year): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT m.name AS module_name, m.slug FROM modules m 
            JOIN studies_groupes_modules sgm ON m.id = sgm.module_id
            JOIN groupes g ON g.id = sgm.group_id
            JOIN studies s ON s.id = sgm.study_id
            JOIN years_studies ys ON s.id = ys.study_id
            JOIN years y ON y.id = ys.year_id
            LEFT JOIN teachs t ON m.id = t.module_id
            WHERE t.module_id IS NULL
            AND g.group_number = ?
            AND s.name = ?
            AND y.name = ?
        ');
        $statement->execute([$group, $study, $year]);
        $modules = [];
        while($row = $statement->fetch()) {
            $module = new Self;
            $module->name = $row['module_name'];
            $module->slug = $row['slug'];
            $modules[] = $module;
        }

        return $modules;
    }
    public function getModulesStudent(int $identifier, string $year): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare('
            SELECT m.name FROM modules m
            JOIN studies_groupes_modules sgm ON m.id = sgm.module_id
            JOIN registrations r ON sgm.group_id = r.group_id
            JOIN years y ON y.id = r.year_id
            JOIN students s ON s.id = r.student_id
            JOIN users u ON u.id = s.user_id
            WHERE u.id = ?
            AND y.name = ?
        ');
        $statement->execute([$identifier, $year]);
        $modules = [];
        while($row = $statement->fetch()) {
            $modules[] = $row['name'];
        }
        return $modules;
    }
    public function getIdModule(string $modue_slug): int
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT id FROM modules WHERE slug = ?'
        );
        $statement->execute([$modue_slug]);
        
        return ($row = $statement->fetch()) ? (int)$row['id'] : 0;
    }
    public function getModule(string $slug):string 
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT name FROM modules WHERE slug = ?'
        );
        $statement->execute([$slug]);
        return ($row = $statement->fetch()) ? $row['name'] : '';
    }
}