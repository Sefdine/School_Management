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
        $_SESSION['nav_top'] = 'home';
        $year = $_SESSION["insert_year"] ?? '';
        $study = $_SESSION["insert_study"] ?? '';
        $group = (int)$_SESSION["insert_group"] ?? 0;
        $admin = new ModelAdmin;
        $years = $admin->getYears();
        $registrer_data = $admin->getTotalInscrit($year, $study, $group);
        $deleted_data = $admin->getTotalDeleted($year, $study, $group);
        $registrer_all = $admin->getAllInscrit();
        $deleted_all = $admin->getAllDeleted();
        require_once('templates/admin/home.php');
    }
    public function displayLanding(string $identifier, string $exam_type = ''): void {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $teacher = new Teacher;
        $years = $teacher->getYears();
        $exams_types = $teacher->getExamsTypes();
        require_once('templates/admin/header.php');
        require_once('templates/admin/landing.php'); 
    }
    public function displayModules(string $identifier, array $data): void {
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $group = (int)$data['group'] ?? 0;
        $study = $data['study'] ?? '';
        $year = $data['year'] ?? '';
        $_SESSION['array'] = $data;
        $modules = (new Teacher)->getModules($group, $study, $year);
        require_once('templates/admin/header.php');
        require_once('templates/admin/module.php');
    }
    public function displayFormRate(string $identifier, string $current_slug, array $data, string $error = ''): void {
        $rates = new Average;
        $users = new ModelUser;
        $user = $users->getUser($identifier);
        $year = $data['year'] ?? '';
        $study = $data['study'] ?? '';
        $group = (int)$data['group'] ?? 0;
        $exam_type = $data['exam_type'] ?? '';
        $exam = $data['exam_name'] ?? '';
        $modules = (new Teacher)->getModules($group, $study, $year);
        $current_module = (new Teacher)->getModule($current_slug);
        require_once('templates/admin/header.php');
        echo '<br>';
        require_once('templates/errors/errors.php');
        require_once('templates/admin/input_rates.php');
    }
    public function displayDashboard(string $error = '', string $year='', string $study='', int $group=1, string $exam_name='', string $exam_type='') : void {
        $admin = new ModelAdmin;
        $current_module = $_SESSION['current_module'] ?? '';
        $counter = $_SESSION['counter'] ?? 0;
        $data = $_SESSION['insert'] ?? [];
        $years = $admin->getYears();
        $studies = $admin->getStudies($year);
        $groupes = $admin->getGroups($year, $study);
        $modules = $admin->getModules($group, $study, $year);
        $exams_types = $admin->getExamsTypes();
        $exams = $admin->getExams($exam_type);
        $count = $admin->getDataCount($year, $study, $group);
        $currentPage = (int)($_SESSION['average_page'] ?? 1);
        $perPage = 10;
        $pages = ceil($count / $perPage);
        $offset = $perPage * ($currentPage - 1);
        $data_users = $admin->getData($exam_name, $current_module, $year, $study, $group, $exam_type, $perPage, $offset);
        $nav_top = $_SESSION['nav_top'] ?? 'insert';
        $session_nav_left = $_SESSION['nav_left'] ?? '';
        $firstname_lastname = $admin->getFirstnameLastname($year, $study, $group);
        $average = new Average;
        $offset_identifier = 0;
        $identifier = $admin->getIdentifier($offset_identifier, $year, $study, $group);
        $user_id = $admin->getIdUser($identifier);
        $user = $admin->getUser((string)$user_id);
        $full_name = $user->firstname.' '.$user->lastname;
        $averages = $average->getAverages($user_id, $exam_name, $exam_type, $year, $study, $group);
        $total_factors_modules = $average->getTotalFactor($year, $study, $group);
        $total_module = $total_factors_modules[0];
        $total_factor = $total_factors_modules[1];
        $total_average = 0;
        $total_factor_average = 0;
        foreach($averages as $item) {
            $total_average += $item->value_average;
            $total_factor_average += ($item->value_average * $item->factor);
        }
        $average = $total_factor_average / $total_factor;
        $page_view_average = (int)$_SESSION['page_view_average'] ?? 1;
        $pages_view_averages = $count;


        if ($nav_top == 'insert') {
            switch($session_nav_left) {
                case 'student': 
                    require_once('templates/admin/insert/student.php');
                    break;
                case 'teacher': 
                    require_once('templates/admin/insert/teacher.php');
                    break;
                case 'average': 
                    require_once('templates/admin/insert/average.php');
                    break;
                default: 
                    require_once('templates/admin/insert/teacher.php');
                    break;
            }
        } elseif ($nav_top == 'view') {
            $page_view_average = 0;
            $total_students = $admin->getTotalInscrit($year, $study, $group);
            $pages_view_averages = ceil($total_students / 10);
            $offset_view_average = 10 * $page_view_average;
            $list_students = $admin->getListStudents($year, $study, $group, $offset_view_average);
            $current_identifier_view_student = $_SESSION['student_list_button'];

            $list_teachers = $admin->getListTeacher($year, $study, $group);
            if (!empty($list_teachers)) {
                $user_id = (int)$list_teachers[0]->identifier;
            }

            $user_id = (int)$_SESSION['teacher_list_button'] ?? 0;
            $info_teachers = $admin->getInfoTeacher($user_id);
            switch($session_nav_left) {
                case 'student': 
                    require_once('templates/admin/view/student.php');
                    break;
                case 'teacher': 
                    require_once('templates/admin/view/teacher.php');
                    break;
                case 'average': 
                    require_once('templates/admin/view/average.php');
                    break;
                default: 
                    require_once('templates/admin/view/teacher.php');
                    break;
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
            $module_slug = $_SESSION['insert_module'] ?? '';
            $module_id = $admin->getIdModule($module_slug);
            $exam = $_SESSION['insert_exam'] ?? 0;
            $exam_id = $admin->getIdExam($exam);
            $year = $_SESSION['insert_year'] ?? '';
            $study = $_SESSION['insert_study'] ?? '';
            $group = (int)$_SESSION['insert_group'] ?? 0;
            $year_id = $admin->getIdYear($year);
            $study_id = $admin->getIdStudy($study);
            $group_id = $admin->getIdGroup($group);
            $counter = 0;
            foreach($data as $k => $value) {
                $identifier = str_replace('_', ' ', $k);
                $user_id = $admin->getIdUser($identifier);
                $student_id = $student->getIdStudent($user_id);
                $registration_id = $admin->getIdRegistration($student_id, $year_id, $study_id, $group_id);
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