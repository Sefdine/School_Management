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
    public function displayInsert(string $error = '', string $year, string $study, string $group, int $level) : void {
        $admin = new ModelAdmin;
        $data = $_SESSION['insert'] ?? [];
        $years = $admin->getYears();
        $studies = $admin->getStudies($year);
        $groupes = $admin->getGroups($year, $study);
        $levels = $admin->getLevels($year, $study, $group);
        $group_slug = $admin->getGroupSlug($group);
        $modules = $admin->getModules((string)$level, $group_slug, $study, $year);
        $session_nav_left = $_SESSION['nav_left'] ?? '';
        $count = $admin->getDataCount($year, $study, $group_slug, $level);
        $currentPage = (int)($_SESSION['average_page'] ?? 1);
        $perPage = 12;
        $pages = ceil($count / $perPage);
        $offset = $perPage * ($currentPage - 1);
        $data_users = $admin->getData($year, $study, $group_slug, $level, $perPage, $offset);
        switch($session_nav_left) {
            case 'student': 
                require_once('templates/admin/insert/student.php');
                break;
            case 'teacher': 
                require_once('templates/admin/insert/teacher.php');
                break;
            case 'study': 
                require_once('templates/admin/insert/study.php');
                break;
            case 'group': 
                require_once('templates/admin/insert/group.php');
                break;
            case 'average': 
                require_once('templates/admin/insert/average.php');
                break;
            default: 
                require_once('templates/admin/insert/student.php');
                break;
        }
    }
    public function insertStudent(array $data): void {
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
                $_SESSION['err'] = 'insert_failed';
                header('Location: '. URL_ROOT .'insert');
            } else {
                $_SESSION['err'] = 'insert_success';
                $_SESSION['insert'][] = $data;
                header('Location: '. URL_ROOT .'insert');
            }
        }
    }
    public function insertTeacher(array $data): void {
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        if(!$firstname || !$lastname) {
            $_SESSION['err'] = 'emptydata';
            header('Location: '. URL_ROOT .'insert');
        } else {
            $admin = new ModelAdmin;
            $success = $admin->insertUserTeacher($data);
        }

        if (!$success) {
            $_SESSION['err'] = 'insert_failed';
            header('Location: '. URL_ROOT .'insert');
        } else {
            $_SESSION['err'] = 'insert_success';
            $_SESSION['insert'][] = $data;
            header('Location: '. URL_ROOT .'insert');
        }
    }
    public function insertStudy(string $name):void {
        if (!$name) {
            $_SESSION['err'] = 'emptydata';
            header('Location: '.URL_ROOT.'insert');
        } else {
            $admin = new ModelAdmin;
            $success = $admin->insertStudy($name);

            if ($success) {
                $_SESSION['err'] = 'insert_success';
                $_SESSION['insert'][] = $name;
                header('Location: '. URL_ROOT .'insert');
            } else {
                $_SESSION['err'] = 'insert_failed';
                header('Location: '. URL_ROOT .'insert');
            }
        }
    }
    public function insertGroup(string $name):void {
        if (!$name) {
            $_SESSION['err'] = 'emptydata';
            header('Location: '.URL_ROOT.'insert');
        } else {
            $slug = str_replace(' ', '-',$name);
            $admin = new ModelAdmin;
            $success = $admin->insertGroup($name, $slug);
            
            if ($success) {
                $_SESSION['err'] = 'insert_success';
                $_SESSION['insert'][] = $name;
                header('Location: '. URL_ROOT .'insert');
            } else {
                $_SESSION['err'] = 'insert_failed';
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