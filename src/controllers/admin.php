<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers;

use Ipem\Src\Model\Average;
use Ipem\Src\Model\Teacher;
use Ipem\Src\Model\User as ModelUser;
use Ipem\Src\Model\Admin as ModelAdmin;
use Ipem\Src\Model\Student;

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
        require_once('templates/admin/header.php');
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
    public function displayDashboard(string $error = '', string $year='', string $study='', string $group='', int $level=0, int $exam=0) : void {
        $admin = new ModelAdmin;
        $current_module = $_SESSION['current_module'] ?? '';
        $counter = $_SESSION['counter'] ?? 0;
        $data = $_SESSION['insert'] ?? [];
        $years = $admin->getYears();
        $studies = $admin->getStudies($year);
        $groupes = $admin->getGroups($year, $study);
        $levels = $admin->getLevels($year, $study, $group);
        $modules = $admin->getModules((string)$level, $group, $study, $year);
        $exams = $admin->getExams();
        $count = $admin->getDataCount($year, $study, $group, $level);
        $currentPage = (int)($_SESSION['average_page'] ?? 1);
        $perPage = 10;
        $pages = ceil($count / $perPage);
        $offset = $perPage * ($currentPage - 1);
        $data_users = $admin->getData($exam, $current_module, $year, $study, $group, $level, $perPage, $offset);
        $nav_top = $_SESSION['nav_top'] ?? 'insert';
        $session_nav_left = $_SESSION['nav_left'] ?? '';

        if ($nav_top == 'insert') {
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
        } elseif ($nav_top == 'update') {
            switch($session_nav_left) {
                case 'student': 
                    require_once('templates/admin/update/student.php');
                    break;
                case 'teacher': 
                    require_once('templates/admin/update/teacher.php');
                    break;
                case 'study': 
                    require_once('templates/admin/update/study.php');
                    break;
                case 'group': 
                    require_once('templates/admin/update/group.php');
                    break;
                case 'average': 
                    require_once('templates/admin/update/average.php');
                    break;
                default: 
                    require_once('templates/admin/update/student.php');
                    break;
            }
        } elseif ($nav_top == 'delete') {
            var_dump('delete');
        }
        
    }
    public function insertStudent(array $data): void {
        $firstname = $data['firstname'] ?? '';
        $lastname = $data['lastname'] ?? '';
        if (!($firstname) || !($lastname)) {
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
    public function insertAverages(array $data):void {
        if (empty($data)) {
            $_SESSION['err'] = 'emptydata';
            header('Location: '.URL_ROOT.'insert');
        } else {
            $admin = new ModelAdmin;
            $student = new Student;
            $module_slug = $_SESSION['current_module'];
            $module_id = $admin->getIdModule($module_slug);
            $exam_id = (int)$_SESSION['data_average']['exam'];
            $year = $_SESSION['data_average']['year'];
            $study = $_SESSION['data_average']['study'];
            $group = $_SESSION['data_average']['group'];
            $level = $_SESSION['data_average']['level'];
            $year_id = $admin->getIdYear($year);
            $study_id = $admin->getIdStudy($study);
            $group_id = $admin->getIdGroup($group);
            $level_id = $admin->getIdLevel((string)$level);
            $counter = 0;
            foreach($data as $k => $value) {
                $identifier = str_replace('_', ' ', $k);
                $user_id = $admin->getIdUser($identifier);
                $student_id = $student->getIdStudent($user_id);
                $registration_id = $admin->getIdRegistration($student_id, $year, $study, $group, $level);
                if ($value) {
                    $average = new Average;
                    $success = $average->insertAverage((float)$value, $registration_id, $module_id, $exam_id);
                    if ($success) {
                        $counter++;
                    }
                }
            }
            if ($counter) {
                $_SESSION['counter'] = $counter;
                $_SESSION['err'] = 'insert_averages_success';
                header('Location: '. URL_ROOT .'displayDashboard');
            } else {
                $_SESSION['err'] = 'insert_failed';
                header('Location: '. URL_ROOT .'displayDashboard');
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