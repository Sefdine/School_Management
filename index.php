<?php

declare(strict_types=1);

use Ipem\Src\Controllers\Student;
use Ipem\Src\Controllers\Admin;
use Ipem\Src\Controllers\User;
use Ipem\Src\Controllers\Average;

use Ipem\Src\Model\Admin as ModelAdmin;
use Ipem\Src\Model\Average as ModelAverage;

require_once('config/config.php');

spl_autoload_register(static function(string $fqcn) {
    $path = substr_replace(strtolower(str_replace(['\\', 'Ipem'], ['/', ''], $fqcn)), '', 0, 1).'.php';
    require_once($path);
});

$student = new Student;
$user = new User;
$admin = new Admin;
$rate = new Average;

if (isset($_GET['action'])){
    $action = $_GET['action'];
}  elseif(isset($_POST['action'])) {
    $action = $_POST['action'];
} else {
    $action = null;
}

$error = $_SESSION['err'] ?? '';
$year = $_SESSION['data_average']['year'] ?? '';
$study = $_SESSION['data_average']['study'] ?? '';
$group = $_SESSION['data_average']['group'] ?? 1;
$exam_type = $_SESSION['data_average']['exam_type'] ?? 'Contrôle';

if (isset($action)){
    if ($action === 'connectionTreatment') {
        if (!empty($_POST['identifier']) && !empty($_POST['password'])) {
            $identifier = $_POST['identifier'];
            $password = $_POST['password'];
            $user->getConnect($identifier, $password);
        } else {
            $_SESSION['err'] = 'empty';
            header('Location: '.URL_ROOT.'errorLogin');
            $_SESSION['err'] = '';
        }
    } elseif ($action === 'home') {
        if (session()) {
            $name = $_SESSION['name'] ?? '';
            $identifier = (string)$_SESSION['user_id'] ?? '';             
            if ($name === 'student') {
                $student->displayHome($identifier);
            } elseif ($name === 'admin') {
                $admin->displayHome();
            } else {
                $user->displayForm();
                die();
            }
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'landing') {
        if (session()) {
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
                $identifier = (string)$_SESSION['user_id'];  
                $name = $_SESSION['name'] ?? '';
                if ($name === 'student') {
                    $student->displayLanding($identifier, $error);
                    $_SESSION['err'] = '';
                } elseif ($name === 'admin') {
                    $admin->displayLanding($identifier);
                } else {
                    $user->displayForm();
                    die();
                }         
            }
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'module'){
        if (session()) {
            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
                $identifier = (string)$_SESSION['user_id'];       
                $admin->displayModules($identifier, $_POST);
            } else {
                $user->displayForm();
                die();              
            }
        } else {
            $user->displayForm();
                die();    
        }
    } elseif ($action === 'rate') {
        if (session()) {
            $identifier = (string)$_SESSION['user_id'];
            $name = $_SESSION['name'] ?? '';
            if ($name === 'student') {
                $year = $_POST['year'] ?? '';
                $exam_type = $_POST['exam_type'] ?? '';
                $exam_name = $_POST['exam_name'] ?? '';

                $student->displayAverage($identifier, $year, $exam_name, $exam_type);
            } elseif ($name === 'admin') {                
                $module_slug = $_GET['module_slug'] ?? '';
                $data = $_SESSION['array'] ?? '';
                if(isset($_SESSION['sessionData']) && $_SESSION['sessionData'] > 0){
                    $_SESSION['data'] = [];
                }
                $admin->displayFormRate($identifier, $module_slug, $data, $error);
                $user->displayForm();
                $_SESSION['err'] = '';
                die();
            }
        } else {
            $user->displayForm();
        }
    } elseif ($action === 'updatePassword') {
        session();
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            $identifier = (string)$_SESSION['user_id'];
            $user->updatePassword($identifier);
        }
    } elseif ($action === 'updatePasswordForm') {
        session();
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            $identifier = (string)$_SESSION['user_id'];
            $user->displayFormUpdatePassword($identifier);
        }
    } elseif ($action === 'updatePasswordTreatment') {
        session();
        if (isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
            $identifier = (string)$_SESSION['user_id'];
            $current_passord = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $new_password_retype = $_POST['new_password_retype'];
            if ($new_password === $new_password_retype) {
                $user->updatePasswordTreatment($identifier, $current_passord, $new_password);
            } else {
                $_SESSION['err'] = 'new_password_retype';
                header('Location: '. URL_ROOT .'errorPassword');
            }
        }
    } elseif ($action === 'rateTreatment') {
        if (session()) {
            $module_slug = $_GET['module_slug'] ?? '';
            $id = (string)$_SESSION['user_id'] ?? '';
            if (isset($_POST)) {
                $rate->update_average($id, $module_slug, $_POST);
            }   
        } else {
            die($user->displayForm());
        } 
    } elseif ($action === 'displayDashboard') {
        if (session()) {
            $year = $_SESSION['insert_year'] ?? date('Y');
            $study = $_SESSION['insert_study'] ?? '';
            $group = (int)($_SESSION['insert_group'] ?? 1);
            $exam_name = $_SESSION['insert_exam'] ?? '';
            $exam_type = $_SESSION['insert_exam_type'] ?? '';
            if (isset($_POST['nav_top'])) {
                $_SESSION['nav_top'] = $_POST['nav_top'];
            }
            if (isset($_POST['nav_left'])) {
                $_SESSION['nav_left'] = $_POST['nav_left'];
            }           
            if (isset($_POST['current_page'])) {
                $_SESSION['average_page'] = $_POST['current_page'];
            }
            
            $admin->displayDashboard($error, $year, $study, $group, $exam_name, $exam_type);   
            $_SESSION['err'] = ''; 
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'insertStudent') {
        if (session()) {
            $admin = new ModelAdmin;
            $year = $_SESSION['insert_year'] ?? '';
            $study = $_SESSION['insert_study'] ?? '';
            $group = (int)$_POST['group'] ?? 0;
            $data = json_decode($_POST['data'], true) ?? [];
            $password = $user::createPassword('IPEM2022');
            $token = $user::createToken($firstname.$lastname);
            $success = $admin->insertUserStudent($data, $password, $token, $year, $study, $group);
            echo $success;
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'insertTeacher') {
        if (session()) {
            $year = $_SESSION['insert_year'] ?? '';
            $study = $_SESSION['insert_study'] ?? '';
            $modulesFirstYear = $_POST['modulesFirstYear'] ?? [];
            $modulesSecondYear = $_POST['modulesSecondYear'] ?? [];
            $data = json_decode($_POST['data'], true) ?? [];
            $admin = new ModelAdmin;
            $success = $admin->insertUserTeacher($data, $modulesFirstYear, $modulesSecondYear, $year, $study);
            echo $success;
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'insertAverages') {
        if (session()) {
            $data = $_POST ?? [];
            $admin->insertAverages($data);
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'ajax') {
        if (session()) {
            if (isset($_POST['value'])) {
                $admin = new ModelAdmin;
                $select = $_POST['select'] ?? '';
                if ($select == 'year') {
                    $value = $_POST['value'];
                    $_SESSION['insert_year'] = $value;
                    $_SESSION['insert_offset_identifier'] = 0;
                    $response = $admin->getStudies($value);
                } elseif ($select == 'study') {
                    $value = $_POST['value'];
                    $_SESSION['insert_study'] = $value;
                    $response = $admin->getGroups($_SESSION['insert_year'], $value);
                } elseif ($select == 'group') {
                    $value = (int)$_POST['value'];
                    $_SESSION['insert_group'] = $value;
                    $study = $_SESSION['insert_study'] ?? '';
                    $year = $_SESSION['insert_year'] ?? '';
                    $response = $admin->getModules($value, $study, $year);
                } elseif ($select == 'exam_type') {
                    $value = $_POST['value'];
                    $_SESSION['insert_exam_type'] = $value;
                    $response = $admin->getExams($value);
                } elseif ($select == 'exam') {
                    $value = $_POST['value'];
                    $_SESSION['insert_exam'] = $value;
                    $group = (int)($_SESSION['insert_group'] ?? 1);
                    $study = $_SESSION['insert_study'] ?? '';
                    $year = $_SESSION['insert_year'] ?? '';
                    $response = $admin->getModules($group, $study, $year);
                } elseif ($select == 'module') {
                    $_SESSION['insert_module'] = $_POST['value'];
                    $exam_name = $_SESSION['insert_exam'] ?? '';
                    $module_slug = $_POST['value'] ?? '';
                    $year = $_SESSION['insert_year'] ?? '';
                    $study = $_SESSION['insert_study'] ?? '';
                    $group = (int)($_SESSION['insert_group'] ?? 1);
                    $exam_type = $_SESSION['insert_exam_type'] ?? '';
                    $perPage = 10;
                    $currentPage = (int)($_SESSION['average_page'] ?? 1);
                    $offset = $perPage * ($currentPage - 1);
                    $response = $admin->getData($exam_name, $module_slug, $year, $study, $group, $exam_type, $perPage, $offset);
                }
                echo json_encode($response);
            }
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'releve') {
        if (session()) {
            $admin = new ModelAdmin;
            $identifier = firstOfReleve($admin);
            $year = $_SESSION['insert_year'];
            $study = $_SESSION['insert_study'];
            $group = (int)($_SESSION['insert_group'] ?? 1);
            $offset_identifier = $_SESSION['insert_offset_identifier'] ?? 0;
            if (!$identifier) {
                $identifier = $admin->getIdentifier($offset_identifier, $year, $study, $group);
            }
            $data = [];
            $data['identifier'] = $identifier;
            $data['year'] = $year;
            $data['study'] = $study;
            $data['group'] = $group;
            
            $user_id = $admin->getIdUser($identifier);
            $user = $admin->getUser((string)$user_id);
            $full_name = $user->firstname.' '.$user->lastname;
            $data['full_name'] = $full_name;
            
            $average = new ModelAverage;
            $exam_name = $_SESSION['insert_exam'];
            $exam_type = $_SESSION['insert_exam_type'];
            $averages = $average->getAverages($user_id, $exam_name, $exam_type, $year, $study, $group);
            $data['averages'] = $averages;
            
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
            $data['total_module'] = $total_module;
            $data['average'] = round($average, 2);
            $pages_view_averages = $admin->getDataCount($year, $study, $group);
            $page_view_average = (int)$_SESSION['insert_offset_identifier'] ?? 1;
            $data['pages_view_averages'] = $pages_view_averages;
            $data['page_view_average'] = $page_view_average;

            echo json_encode($data);
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'releveExam') {
        if (session()) {
            $admin = new ModelAdmin;
            $identifier = firstOfReleve($admin);
            $year = $_SESSION['insert_year'];
            $study = $_SESSION['insert_study'];
            $group = (int)($_SESSION['insert_group'] ?? 1);
            $offset_identifier = $_SESSION['insert_offset_identifier'] ?? 0;
            if (!$identifier) {
                $identifier = $admin->getIdentifier($offset_identifier, $year, $study, $group);
            }
            $data = [];
            $data['identifier'] = $identifier;
            $data['year'] = $year;
            $data['study'] = $study;
            $data['group'] = $group;
            
            $user_id = $admin->getIdUser($identifier);
            $user = $admin->getUser((string)$user_id);
            $full_name = $user->firstname.' '.$user->lastname;
            $data['full_name'] = $full_name;
            
            $average = new ModelAverage;
            $averages = $average->getDataReleveExam($year, $study, $group, $identifier);
            $total_factor = 0;
            $total_controls = 0;
            $total_exam_theorique = 0;
            $total_exam_pratique = 0;
            foreach($averages as $item) {
                $total_factor += $item->factor;
                $total_controls += $item->controles * $item->factor;
                $total_exam_theorique += $item->theorical * $item->factor;
                $total_exam_pratique += $item->pratical * $item->factor;
            }
            $pages_view_averages = $admin->getDataCount($year, $study, $group);
            $page_view_average = (int)$_SESSION['insert_offset_identifier'] ?? 1;
            $data['pages_view_averages'] = $pages_view_averages;
            $data['page_view_average'] = $page_view_average;
            if ($total_factor == 0) {
                $data['action'] = 'error';
                echo json_encode($data);
                die();
            }
            $data['averages'] = $averages;
            $data['total_factor'] = $total_factor;
            $data['total_controls'] = round($total_controls, 2);
            $data['total_exam_theorique'] = round($total_exam_theorique, 2);
            $data['total_exam_pratique'] = round($total_exam_pratique, 2);

            $data['ga_control_value'] = round(($total_controls / $total_factor), 2);
            $data['ga_exam_theorique_value'] = round(($total_exam_theorique / $total_factor), 2);
            $data['ga_exam_pratique_value'] = round(($total_exam_pratique / $total_factor), 2);
            $total = ($data['ga_control_value']*3 + $data['ga_exam_theorique_value']*2 + $data['ga_exam_pratique_value']*3);
            $data['fa_value'] = round(($total / 8), 2);
            

            echo json_encode($data);
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'studentView') {
        $admin = new ModelAdmin;
        $select = $_POST['select'] ?? '';
        $value = $_POST['value'] ?? '';
        if ($select == 'group') {
            $_SESSION['insert_group'] = $value;
            $_SESSION['student_list_button'] = '';
            $_SESSION['page_view_average'] = 0;
        } elseif ($select == 'button_ouvrir') {
            $_SESSION['student_list_button'] = $value;
        } elseif ($select == 'next') {
            $_SESSION['page_view_average'] += 1;
        } elseif ($select == 'previous') {
            $_SESSION['page_view_average'] -= 1;
        }
        $current_identifier_view_student = $_SESSION['student_list_button'];
        $year = $_SESSION['insert_year'];
        $study = $_SESSION['insert_study'];
        $group = (int)$_SESSION['insert_group'];
        $data = [];
        $page_view_average = $_SESSION['page_view_average'];
        $total_students = $admin->getTotalInscrit($year, $study, $group);
        $pages_view_averages = ceil($total_students / 10);
        $offset_view_average = 10 * $page_view_average;
        $list_students = $admin->getListStudents($year, $study, $group, $offset_view_average);
        if (!$current_identifier_view_student && !empty($list_students)) {
            $current_identifier_view_student = $list_students[0]->identifier;
        }
        $info_student = $admin->getInfoStudent($current_identifier_view_student);
        $data['page_view_average'] = $page_view_average;
        $data['pages_view_averages'] = $pages_view_averages;
        $data['list_students'] = $list_students;
        $data['info_student'] = $info_student;
        $data['current_identifier_view_student'] = $current_identifier_view_student;

        echo json_encode($data);
    } elseif ($action === 'teacherView') {
        if (session()) {
            $select = $_POST['select'];
            $value = $_POST['value'];
            $admin = new ModelAdmin;
            if ($select == 'group') {
                $_SESSION['insert_group'] = $value;
                $_SESSION['teacher_list_button'] = 0;
            } elseif ($select == 'button_ouvrir') {
                $_SESSION['teacher_list_button'] = $value;
            }
            $year = $_SESSION['insert_year'];
            $study = $_SESSION['insert_study'];
            $group = (int)$_SESSION['insert_group'];

            $data = [];
            $teacher_id = (int)$_SESSION['teacher_list_button'] ?? 0;
            $list_teachers = $admin->getListTeacher($year, $study, $group);
            if (!$teacher_id && !empty($list_teachers)) {
                $teacher_id = (int)$list_teachers[0]->identifier;
            }

            $info_teachers = $admin->getInfoTeacher($teacher_id);
            $modules_teachers = $admin->getModulesTeachers($teacher_id);
            $data['info_teachers'] = $info_teachers;
            $data['teacher_id'] = $teacher_id;
            $data['list_teachers'] = $list_teachers;
            $data['modules_teachers'] = $modules_teachers;

            echo json_encode($data);
        } else {
            die($admin->displayForm());
        }
    } elseif ($action === 'homeAdmin') {
        if (session()) {
            $select = $_POST['select'];
            $value = $_POST['value'];
            $admin = new ModelAdmin;
            if ($select == 'group') {
                $_SESSION['insert_group'] = $value;
            }
            $data = [];
            $year = $_SESSION["insert_year"] ?? '';
            $study = $_SESSION["insert_study"] ?? '';
            $group = (int)$_SESSION["insert_group"] ?? 0;
            $registrer_data = $admin->getTotalInscrit($year, $study, $group);
            $deleted_data = $admin->getTotalDeleted($year, $study, $group);
            $data['registrer_data'] = $registrer_data;
            $data['deleted_data'] = $deleted_data;

            $session_nav_left = $_SESSION['nav_left'];
            switch ($session_nav_left) {
                case 'student': 
                    $students = $admin->getStudentsData($year, $study, $group);
                    $data['students'] = $students;
                    break;
                case 'teacher':
                    $teachers = $admin->getTeacherData($year, $study, $group);
                    $data['teachers'] = $teachers;
                    break;
                case 'average':
                    $modules = $admin->getModulesData($year, $study, $group);
                    $students = $admin->getStudentsData($year, $study, $group);
                    $data['students'] = $students;
                    $data['modules'] = $modules;
                    break;
                default:
                    $teachers = $admin->getTeacherData($year, $study, $group);
                    $data['teachers'] = $teachers;
                    break;
            }
            
            echo json_encode($data);
        } else {
            die($admin->displayForm());
        }
    } elseif ($action === 'errorLogin') {
        $login_err = $_SESSION['err'] ?? '';
        $user->displayForm($login_err);
        $_SESSION['err'] = ''; 
    } elseif ($action === 'errorPassword') {
        if (session()) {
            if (isset($_SESSION['err']) && isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0) {
                $login_err = $_SESSION['err'];
                $identifier = (string)$_SESSION['user_id'];
                $user->displayFormUpdatePassword($identifier, $login_err);
                $_SESSION['err'] = '';
            }     
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'disconnect') {
        session_destroy();
        header('Location: index.php');
    } else {
        session_destroy();
        $user->displayForm();
        die();
    }
} else {
    die($user->displayForm());
}


function firstOfReleve($admin) {
    $select = $_POST['select'] ?? '';
    $value = $_POST['value'];
    if ($select == 'exam') {
        $_SESSION['insert_exam'] = $value;
    } elseif ($select == 'group') {
        $_SESSION['insert_group'] = $value;
    } elseif ($select == 'previous') {
        $_SESSION['insert_offset_identifier'] -= 1;
    } elseif ($select == 'next') {
        $_SESSION['insert_offset_identifier'] += 1;
    } elseif ($select == 'identifier') {
        if (!$value) {
            die(0);
        }
        $year = $_SESSION['insert_year'];
        $study = $_SESSION['insert_study'];
        $group = (int)($_SESSION['insert_group'] ?? 1);
        $identifiers = $admin->getIdentifiers($year, $study, $group);
        $rep = 0;
        $identifier = null;
        foreach($identifiers as $item) {
            if ((trim($value) == trim($item)) && (!is_null($item))) {
                $identifier = $item;
                $rep = 1;
                break;
            }
        }
        if ($rep == 0) {
            die(0);
        }
    }
    return $identifier;
}