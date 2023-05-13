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

        if ($exam_type == 'Examen') {
            $identifier = $student->getIdentifierStudent((int)$identifier);
            $averages = $rate->getDataReleveExam($year, $study, $group, $identifier);
            $total_controls = 0;
            $total_exam_theorical = 0;
            $total_exam_pratical = 0;
            foreach($averages as $item) {
                $total_controls += $item->controles * $item->factor;
                $total_exam_theorical += $item->theorical * $item->factor;
                $total_exam_pratical += $item->pratical * $item->factor;
            }
            $ga_controls = round($total_controls / $total_factor, 2);
            $ga_exam_theorical = round($total_exam_theorical / $total_factor, 2);
            $ga_exam_pratical = round($total_exam_pratical / $total_factor, 2);

            $final_average = ($ga_controls*3 + $ga_exam_theorical*2 + $ga_exam_pratical*3) / 8;
        }
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
