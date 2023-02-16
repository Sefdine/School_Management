<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Average as ModelAverage;
use Ipem\Src\Model\Student as ModelStudent;
use Ipem\Src\Model\User as ModelUser;
use Ipem\Src\Model\Teacher as ModelTeacher;

class Average
{
    public function update_rate(string $id, string $module, array $data): void
    {
        $identifier = $data['num_inscription'].' ' ?? '';
        $value = (float)($data['rate'] ?? 0);
        $users = new ModelUser;

        $user_id = $users->getIdUser($identifier);

        if ($identifier) {
            $students = new ModelStudent;
            $student_id = $students->getIdStudent($user_id);

            $array = $_SESSION['array'];
            $year = $array['year'];
            $study = $array['study'];
            $group = $array['group'];
            $level = $array['level'];
            $exam = $array['control'];

            $teacher = new ModelTeacher;
            $year_id = $teacher->getIdYear($year);
            $study_id = $teacher->getIdStudy($study);                
            $group_id = $teacher->getIdGroup($group);
            $level_id = $teacher->getIdLevel($level);
            $module_id = $teacher->getIdModule($module);
            $exam_id = $teacher->getIdExam($exam);
            $contain_id = $teacher->getIdContain($year_id, $study_id, $group_id, $level_id);
            $registration_id = 0;
            $registration_id = $students->getIdRegistration($student_id, $contain_id);
            
            if ($registration_id) {
                $averages = new ModelAverage;
                $user = $users->getUser((string)$user_id);
                $full_name = implode(' ', [$user->lastname, $user->firstname]);

                $success = $averages->insertAverage($value, $registration_id, $module_id, $exam_id);
            } else {
                header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=invalid_num_inscription');
                die();
            }
        } else {
            header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=empty_numInscription');
            die();
        }

        if ($success) {
            $_SESSION['data'][] = [$identifier, $full_name, $value];
            header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=rateSuccess');
            die();
        } else {
            header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=rateError');
            die();
        }
    }
}