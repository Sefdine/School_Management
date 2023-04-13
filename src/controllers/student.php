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

    public function displayLanding(string $identifier, string $error = '', string $exam_type = ''): void 
    {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $student = new ModelStudent;
        $years = $student->getYears();
        $exams_types = $student->getExamsTypes();

        $exams = $student->getExams($exam_type);
        require_once('templates/student/header.php');
        require_once('templates/errors/errors.php');
        require_once('templates/student/landing.php');
    }

    public function displayAverage(string $identifier, string $year, string $exam_name, string $exam_type): void
    {
        $users = new ModelUser;
        $title = 'Consultaion des notes';
        $user = $users->getUser($identifier);
        $student = new ModelStudent;
        $array = $student->getDataStudent($year, $exam_name, $exam_type, (int)$identifier);
        $study = $array['study'];
        $group = (int)$array['group'];
        $num_inscription = $array['num_inscription'];
        $rate = new Average;
        $rates = $rate->getAverages((int)$identifier, $exam_name, $exam_type, $year, $study, $group);
        $total_factors_modules = $rate->getTotalFactor($year, $study, $group);
        $total_module = $total_factors_modules[0];
        $total_factor = $total_factors_modules[1];
        $total_average = 0;
        $total_factor_average = 0;
        foreach($rates as $item) {
            $total_average += $item->value_average;
            $total_factor_average += ($item->value_average * $item->factor);
        }
        $average = $total_factor_average / $total_factor;
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
}
