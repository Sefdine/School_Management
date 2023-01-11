<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;


use Ipem\Src\Model\Rate;
use Ipem\Src\Model\Teacher as ModelTeacher;
use Ipem\Src\Model\User as ModelUser;

class Teacher extends User
{
    public function displayFormRate(string $identifier, string $current_module, array $data, string $error = ''): void
    {
        $rates = new Rate;
        $users = new ModelUser;
        $user = $users->getUser('teacher', $identifier);
        $year = $data['year'];
        $study = $data['study'];
        $group = $data['group'] ?? '';
        $level = $data['level'] ?? '';
        $control = $data['control'] ?? '';
        $modules = (new ModelTeacher)->getModules($identifier, $level, $group);
        require_once('templates/teacher/header.php');
        echo '<br>';
        require_once('templates/errors/errors.php');
        require_once('templates/teacher/input_rates.php');
    }

    public function displayLanding(string $identifier): void
    {
        $users = new ModelUser;
        $user = $users->getuser('teacher', $identifier);
        $teacher = new ModelTeacher;
        $years = $teacher->getYears($identifier);
        $studies = $teacher->getStudies();
        $groups = $teacher->getGroups();
        $levels = $teacher->getlevels($identifier);
        $controls = $teacher->getControls();
        require_once('templates/teacher/landing.php'); 
    }

    public function displayModules(string $identifier, array $data): void
    {
        $users = new ModelUser;
        $user = $users->getuser('teacher', $identifier);
        $group = $data['group'] ?? '';
        $level = $data['level'] ?? '';
        $_SESSION['array'] = $data;
        $modules = (new ModelTeacher)->getModules($identifier, $level, $group);
        require_once('templates/teacher/header.php');
        require_once('templates/teacher/module.php');
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