<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Rate as ModelRate;
use Ipem\Src\Model\Student as ModelStudent;
use Ipem\Src\Model\User as ModelUser;

class Rate
{
    public function update_rate(string $id, string $module, array $data): void
    {
        $num_inscription = $data['num_inscription'] ?? '';
        $value = (float)($data['rate'] ?? 0);
        $rate = new ModelRate;
        $student = new ModelStudent;

        if ($num_inscription) {
            $identifier = $student->getId($num_inscription);
            if ($identifier) {
                $users = new ModelUser;
                $user = $users->getuser('student', (string)$identifier);
                $array = $_SESSION['array'];
                $year = $array['year'];
                $study = $array['study'];
                $group = $array['group'];
                $level = $array['level'];
                $control = $array['control'];
                $full_name = implode(' ', [$user->lastname, $user->firstname]);
                $success = $rate->updateRate($num_inscription, $year, $study, $group, $level, $control, $module, $value);
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

    /* protected static function getNameModule(): array
    {
        $modules = [
            'Français' => 'french',
            'Anglais' => 'english',
            'Marketing' => 'marketing',
            'Comptabilité Général' => 'accounting',
            'Informatique' => 'office',
            'Statistique' => 'statistics',
            "Gestion de l'entreprise" => 'business_management',
            'Gestion administrative' => 'admin_managemen',
            'Législation du travail' => 'work_legislation',
            'Mathématique financière' => 'financial_math',
        ];

        return $modules;
    } */
}