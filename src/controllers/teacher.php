<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;


use Ipem\Src\Model\Rate;
use Ipem\Src\Model\Teacher as ModelTeacher;
use Ipem\Src\Model\User as ModelUser;

class Teacher extends User
{
    public function displayFormRate(string $identifier, string $current_module, string $error = ''): void
    {
        $rates = new Rate;
        $users = new ModelUser;
        $user = $users->getUser('teacher', $identifier);
        $full_names = self::getFullName($rates->getRates());
        $modules = (new ModelTeacher)->getModules($identifier);
        require_once('templates/teacher/header.php');
        echo '<br>';
        require_once('templates/errors/errors.php');
        require_once('templates/teacher/input_rates.php');
    }

    public function displayHome(string $identifier): void
    {
        $users = new ModelUser;
        $user = $users->getuser('teacher', $identifier);
        $modules = (new ModelTeacher)->getModules($identifier);
        require_once('templates/teacher/header.php');
        require_once('templates/teacher/home.php');
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