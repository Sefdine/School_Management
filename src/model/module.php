<?php 

declare(strict_types = 1);

namespace Ipem\Src\Model;

use Ipem\Src\Lib\Database;

trait Module
{
    public $name;
    public $slug;

    public function getModules(string $identifier, string $level, string $group_slug): array
    {
        $connection = new Database;
        $statement = $connection->getConnection()->prepare(
            'SELECT m.name AS module_name, m.slug FROM modules m 
            JOIN teachs t ON m.id = t.module_id
            JOIN contain c ON c.id = t.contain_id
            JOIN levels l ON l.id = c.level_id
            JOIN groupes g ON g.id = c.group_id
            JOIN teachers tc ON tc.id = t.teacher_id
            AND tc.user_id = ?
            AND l.level = ?
            AND g.slug = ?'
        );
        $statement->execute([$identifier, $level, $group_slug]);
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
            JOIN levelsmodules lm ON m.id = lm.module_id
            JOIN levels l ON l.id = lm.level_id
            JOIN contain c ON l.id = c.level_id
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
        
        return ($row = $statement->fetch()) ? $row['id'] : 0;
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