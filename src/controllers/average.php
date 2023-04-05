<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Average as ModelAverage;
use Ipem\Src\Model\Student as ModelStudent;
use Ipem\Src\Model\User as ModelUser;
use Ipem\Src\Model\Teacher as ModelTeacher;

class Average
{
    public function update_average(string $id, string $module_slug, array $data): void
    {
        $identifier = $data['num_inscription'].' ' ?? '';
        $value = (float)($data['rate'] ?? 0);
        $users = new ModelUser;

        $user_id = $users->getIdUser($identifier);
        $_SESSION['sessionData'] = 0;

        if ($identifier) {
            $students = new ModelStudent;
            $student_id = $students->getIdStudent($user_id);

            $array = $_SESSION['array'];
            $year = $array['year'];
            $study = $array['study'];
            $group_slug = $array['group'];
            $level = $array['level'];
            $exam = $array['control'];

            $teacher = new ModelTeacher;
            $year_id = $teacher->getIdYear($year);
            $study_id = $teacher->getIdStudy($study);                
            $group_id = $teacher->getIdGroup($group_slug);
            $level_id = $teacher->getIdLevel($level);
            $module_id = $teacher->getIdModule($module_slug);
            $exam_id = $teacher->getIdExam($exam);
            $registration_id = 0;
            $registration_id = $students->getIdRegistration($student_id, $year_id, $study_id, $group_id, $level_id);
            
            if ($registration_id) {
                $averages = new ModelAverage;
                $user = $users->getUser((string)$user_id);
                $full_name = implode(' ', [$user->lastname, $user->firstname]);

                $success = $averages->insertAverage($value, $registration_id, $module_id, $exam_id);
            } else {
                $_SESSION['err'] = 'invalid_num_inscription';
                header('Location: '. URL_ROOT .'rate/'.$module_slug);
                die();
            }
        } else {
            $_SESSION['err'] = 'empty_numInscription';
            header('Location: '. URL_ROOT .'rate/'.$module_slug);
            die();
        }

        if ($success) {
            $_SESSION['data'][] = [$identifier, $full_name, $value];
            $_SESSION['err'] = 'rateSuccess';
            header('Location: '. URL_ROOT .'rate/'.$module_slug);
            die();
        } else {
            $_SESSION['err'] = 'rateError';
            header('Location: '. URL_ROOT .'rate/'.$module_slug);
            die();
        }
    }
}