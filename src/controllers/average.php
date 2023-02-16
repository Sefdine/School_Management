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
        $num_inscription = $data['num_inscription'].' ' ?? '';
        $value = (float)($data['rate'] ?? 0);
        $rate = new ModelAverage;
        $student = new ModelStudent;

        if ($num_inscription) {
            $array = $_SESSION['array'];
            $year = $array['year'];
            $study = $array['study'];
            $group = $array['group'];
            $level = $array['level'];
            $control = $array['control'];

            $teacher = new ModelTeacher;
            $id_year = $teacher->getIdYear($year);
            $id_study = $teacher->getIdStudy($study, $id_year);                
            $id_group = $teacher->getIdGroup($group, $id_study);
            $id_level = $teacher->getIdLevel($level, $id_group);
            $id_module = $teacher->getIdModule($module, $id_level);
            $identifier = $student->getIdRegistration($num_inscription, $id_level);
            if ($identifier) {
                $users = new ModelUser;
                $user = $users->getUser((string)$identifier);
                $full_name = implode(' ', [$user->lastname, $user->firstname]);

                $id_rate = $rate->checkRateIfExist($num_inscription, $year, $study, $group, $level, $control, $module);

                if($id_rate) {
                    $success = $rate->updateRate($id_rate, $value);
                } else {
                    $id_control = (int)$control;
                    $success = $rate->insertRate($value, $identifier, $id_module, $id_control, $id_year);
                }  
            } else {
                header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=invalid_num_inscription');
                die();
            }
        } else {
            header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=empty_numInscription');
            die();
        }

        if ($success) {
            $_SESSION['data'][] = [$num_inscription, $full_name, $value];
            header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=rateSuccess');
            die();
        } else {
            header('Location: index.php?action=rate&id='.$id.'&module='.$module.'&error=rateError');
            die();
        }
    }
}