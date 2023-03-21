<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Average;
use Ipem\Src\Model\Teacher as ModelTeacher;
use Ipem\Src\Model\User as ModelUser;

class Admin extends User
{
    public function displayLanding(string $identifier): void
    {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $teacher = new ModelTeacher;
        $years = $teacher->getYears();
        $studies = $teacher->getStudies();
        $groups = $teacher->getGroups();
        $levels = $teacher->getlevels();
        $controls = $teacher->getExams();
        require_once('templates/admin/landing.php'); 
    }

    public function displayModules(string $identifier, array $data): void
    {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $group_slug = $data['group'] ?? '';
        $level = $data['level'] ?? '';
        $study = $data['study'] ?? '';
        $year = $data['year'] ?? '';
        $_SESSION['array'] = $data;
        $modules = (new ModelTeacher)->getModules($level, $group_slug, $study, $year);
        require_once('templates/admin/header.php');
        require_once('templates/admin/module.php');
    }

    public function displayFormRate(string $identifier, string $current_slug, array $data, string $error = ''): void
    {
        $rates = new Average;
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $year = $data['year'] ?? '';
        $study = $data['study'] ?? '';
        $group_slug = $data['group'] ?? '';
        $level = $data['level'] ?? '';
        $control = $data['control'] ?? '';
        $modules = (new ModelTeacher)->getModules($level, $group_slug, $study, $year);
        $current_module = (new ModelTeacher)->getModule($current_slug);
        $group_name = (new ModelTeacher)->getGroup($group_slug);
        require_once('templates/admin/header.php');
        echo '<br>';
        require_once('templates/errors/errors.php');
        require_once('templates/admin/input_rates.php');
    }

    protected static function getFullName(array $names): array
    {
        $full_name = [];
        foreach($names as $name) {
            $full_name[] = implode(' ', [$name->lastname, $name->firstname]);
        }
        return $full_name;
    }
}