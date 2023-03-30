<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Module
{
    public $name;
    public $slug;

    public function getModules(string $level, string $group_slug, string $study, string $year): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT m.name AS module_name, m.slug FROM modules m 
            JOIN contain_modules cm ON m.id = cm.module_id
            JOIN contain c ON c.id = cm.contain_id
            JOIN groupes g ON g.id = c.group_id
            JOIN levels l ON l.id = c.level_id
            JOIN studies s ON s.id = c.study_id
            JOIN years y ON y.id = c.year_id 
            WHERE l.level = ?
            AND g.slug = ?
            AND s.name = ?
            AND y.name = ?'
        );
        $statement->execute([$level, $group_slug, $study, $year]);
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
        $statement = $connection->getConnection()->prepare(
            'SELECT m.name FROM modules m
            JOIN contain_modules cm ON m.id = cm.module_id
            JOIN contain c ON c.id = cm.contain_id
            JOIN years y ON y.id = c.year_id
            JOIN registrations r ON c.id = r.contain_id
            JOIN students s ON s.id = r.student_id
            JOIN users u ON u.id = s.user_id
            AND u.id = ?
            AND y.name = ?'
        );
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