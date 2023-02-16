<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Average;
use Ipem\Src\Model\User as ModelUser;
use Ipem\Src\Model\Student as ModelStudent;

class Student extends User
{
    public function displayHome(string $identifier): void 
    {
        $student = new ModelUser;
        $user = $student->getUser($identifier);
        require_once('templates/student/header.php');
        require_once('templates/student/home.php');
    }

    public function displayLanding(string $identifier, string $error = ''): void 
    {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $student = new ModelStudent;
        $years = $student->getYears();
        $controls = $student->getExams();
        require_once('templates/student/header.php');
        require_once('templates/errors/errors.php');
        require_once('templates/student/landing.php');
    }

    public function displayAverage(string $identifier, string $year, string $control): void
    {
        $users = new ModelUser;
        $title = 'Consultaion des notes';
        $user = $users->getUser($identifier);
        $student = new ModelStudent;
        $array = $student->getData($year, (int)$identifier);
        $study = $array['study'];
        $group = $array['group'];
        $level = $array['level'];
        $num_inscription = $array['num_inscription'];
        $modules = $student->getModulesStudent((int)$identifier, $year);
        $rate = new Average;
        $rates = $rate->getAverages((int)$identifier, (int)$control, $year);
        $data = self::getData($modules, $rates);
        $average = self::getAverage($rates);
        require_once('templates/student/header.php');
        require_once('templates/student/display_rate.php');
    }

    protected static function getData(array $modules, array $rates): array
    {
        $data = [];
        foreach($modules as $module){
            foreach($rates as $k => $rate){
                if($k === $module) {
                    $data[$module] = $rate;
                } 
            }
        }

        return $data;
    }

    protected static function getAverage(array $data): float
    {
        $total = array_sum($data);
        
        return $total / 10;
    }
}
