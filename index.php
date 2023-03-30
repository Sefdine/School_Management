<?php

declare(strict_types=1);

use Ipem\Src\Controllers\Student;
use Ipem\Src\Controllers\Admin;
use Ipem\Src\Controllers\User;
use Ipem\Src\Controllers\Average;

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
}  else {
    $action = null;
}

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
            $identifier = $_GET['id'] ?? '';             
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
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];  
                $error = $_SESSION['err'] ?? '';           
                $student->displayLanding($identifier, $error);
                $_SESSION['err'] = '';
            }
        } else {
            die($user->displayForm());
        }
    } elseif($action === 'module'){
        session();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];       
            $admin->displayModules($identifier, $_POST);
        } else {
            $user->displayForm();
            die();              
        }
    } elseif ($action === 'rate') {
        session();
        $name = $_SESSION['name'] ?? '';
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];
            if ($name === 'student') {
                $year = $_POST['year'] ?? '';
                $control = $_POST['control'] ?? '';
                $student->displayAverage($identifier, $year, $control);
            } elseif ($name === 'admin') {                
                $module_slug = $_GET['module_slug'] ?? '';
                $error = $_SESSION['err'] ?? '';
                $data = $_SESSION['array'] ?? '';
                if(isset($_SESSION['sessionData']) && $_SESSION['sessionData'] > 0){
                    $_SESSION['data'] = [];
                }
                $admin->displayFormRate($identifier, $module_slug, $data, $error);
                $user->displayForm();
                $_SESSION['err'] = '';
                die();
            }
        }
    } elseif ($action === 'updatePassword') {
        session();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];
            $user->updatePassword($identifier);
        }
    } elseif ($action === 'updatePasswordForm') {
        session();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];
            $user->displayFormUpdatePassword($identifier);
        }
    } elseif ($action === 'updatePasswordTreatment') {
        session();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];
            $current_passord = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $new_password_retype = $_POST['new_password_retype'];
            if ($new_password === $new_password_retype) {
                $user->updatePasswordTreatment($identifier, $current_passord, $new_password);
            } else {
                $_SESSION['err'] = 'new_password_retype';
                header('Location: '. URL_ROOT .'errorPassword/'.$identifier);
            }
        }
    } elseif ($action === 'rateTreatment') {
        session();
        $module_slug = $_GET['module_slug'] ?? '';
        $id = $_GET['id'] ?? '';
        if (isset($_POST)) {
            $rate->update_average($id, $module_slug, $_POST);
        }     
    } elseif ($action === 'insert') {
        if (session()) {
            $error = $_SESSION['err'] ?? '';
            $year = $_SESSION['data_average']['year'] ?? '2022';
            $study = $_SESSION['data_average']['study'] ?? 'Gestion des entreprises';
            $group = $_SESSION['data_average']['group'] ?? 'Technicien Sp├®cialis├®';
            $level = (int)$_SESSION['data_average']['level'] ?? 1;
            $admin->displayInsert($error, $year, $study, $group, $level);   
            $_SESSION['err'] = ''; 
        } else {
            die($user->displayForm());
        }
    } elseif($action === 'insertStudent') {
        if (session()) {
            $data = $_POST ?? [];
            $admin->insertStudent($data);
        } else {
            die($user->displayForm());
        }
    } elseif($action === 'insertStudy') {
        if (session()) {
            $study_name = $_POST['name'] ?? '';
            $admin->insertStudy($study_name);
        } else {
            die($user->displayForm());
        }
    } elseif($action === 'insertTeacher') {
        if (session()) {
            $data = $_POST ?? [];
            $admin->insertTeacher($data);
        } else {
            die($user->displayForm());
        }
    } elseif($action === 'insertGroup') {
        if (session()) {
            $group = $_POST['name'] ?? '';
            $admin->insertGroup($group);
        } else {
            die($user->displayForm());
        }
    } elseif ($action === 'errorLogin') {
        if (session()) {
            $login_err = $_SESSION['err'];
            $user->displayForm($login_err);
            $_SESSION['err'] = ''; 
        } else {
            die($user->displayForm());
        }  
    } elseif ($action === 'errorPassword') {
        if (session()) {
            if (isset($_SESSION['err']) && isset($_GET['id']) && $_GET['id'] > 0) {
                $login_err = $_SESSION['err'];
                $identifier = $_GET['id'];
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

