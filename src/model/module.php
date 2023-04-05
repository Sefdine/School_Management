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
        $statement = $connection->getConnection()->prepare('
            SELECT m.name AS module_name, m.slug FROM modules m 
            JOIN levels_modules lm ON m.id = lm.module_id
            JOIN levels l ON l.id = lm.level_id
            JOIN groupes_levels gl ON l.id = gl.level_id
            JOIN groupes g ON g.id = gl.group_id
            JOIN studies_groupes sg ON g.id = sg.group_id
            JOIN studies s ON s.id = sg.study_id
            JOIN years_studies ys ON s.id = ys.study_id
            JOIN years y ON y.id = ys.year_id
            WHERE l.level = ?
            AND g.slug = ?
            AND s.name = ?
            AND y.name = ?
        ');
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
        $statement = $connection->getConnection()->prepare('
            SELECT m.name FROM modules m
            JOIN levels_modules lm ON m.id = lm.module_id
            JOIN registrations r ON lm.level_id = r.level_id
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