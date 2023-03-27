<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Average;
use Ipem\Src\Model\Teacher;
use Ipem\Src\Model\User as ModelUser;
use Ipem\Src\Model\Admin as ModelAdmin;

class Admin extends User
{
    public function displayHome():void {
        require_once('templates/admin/home.php');
    }

    public function displayLanding(string $identifier): void {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $teacher = new Teacher;
        $years = $teacher->getYears();
        $studies = $teacher->getStudies();
        $groups = $teacher->getGroups();
        $levels = $teacher->getlevels();
        $controls = $teacher->getExams();
        require_once('templates/admin/landing.php'); 
    }

    public function displayModules(string $identifier, array $data): void {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $group_slug = $data['group'] ?? '';
        $level = $data['level'] ?? '';
        $study = $data['study'] ?? '';
        $year = $data['year'] ?? '';
        $_SESSION['array'] = $data;
        $modules = (new Teacher)->getModules($level, $group_slug, $study, $year);
        require_once('templates/admin/header.php');
        require_once('templates/admin/module.php');
    }

    public function displayFormRate(string $identifier, string $current_slug, array $data, string $error = ''): void {
        $rates = new Average;
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $year = $data['year'] ?? '';
        $study = $data['study'] ?? '';
        $group_slug = $data['group'] ?? '';
        $level = $data['level'] ?? '';
        $control = $data['control'] ?? '';
        $modules = (new Teacher)->getModules($level, $group_slug, $study, $year);
        $current_module = (new Teacher)->getModule($current_slug);
        $group_name = (new Teacher)->getGroup($group_slug);
        require_once('templates/admin/header.php');
        echo '<br>';
        require_once('templates/errors/errors.php');
        require_once('templates/admin/input_rates.php');
    }

    function displayInsert(string $error = '') : void {
        $data_student = $_SESSION['insert_student'] ?? [];
        require_once('templates/errors/errors.php');
        require_once('templates/admin/insert/index.php');
    }

    function insertStudent(array $data): void {
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        $identifier = $data['identifier'] ?? '';
        $nationality = $data['nationality'] ?? '';
        if (!($firstname) || !($lastname) || !($identifier) || !($nationality) ) {
            $_SESSION['err'] = 'emptydata';
            header('Location: '. URL_ROOT .'insert');
        } else {
            $admin = new ModelAdmin;
            $password = self::createPassword('IPEM2022');
            $token = self::createToken($firstname.$lastname);
            $success = $admin->insertUserStudent($data, $password, $token);

            if (!$success) {
                $_SESSION['err'] = 'insert_student_failed';
                header('Location: '. URL_ROOT .'insert');
            } else {
                $_SESSION['err'] = 'insert_student_success';
                $_SESSION['insert_student'][] = $data;
                header('Location: '. URL_ROOT .'insert');
            }
        }
    }

    protected static function getFullName(array $names): array {
        $full_name = [];
        foreach($names as $name) {
            $full_name[] = implode(' ', [$name->lastname, $name->firstname]);
        }
        return $full_name;
    }
}