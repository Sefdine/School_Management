<?php

declare(strict_types=1);

use Ipem\Src\Controllers\Student;
use Ipem\Src\Controllers\Admin;
use Ipem\Src\Controllers\User;
use Ipem\Src\Controllers\Average;

require_once('config/config.php');

session_start();

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
    if ($action === 'connectionTreatment') {
        if (!empty($_POST['identifier']) && !empty($_POST['password'])) {
            $identifier = $_POST['identifier'];
            $password = $_POST['password'];
            $user->getConnect($identifier, $password);
        } else {
            header('Location: index.php?action=errorLogin&login_err=empty');
        }
    } elseif ($action === 'home') {
        issetSesionUser();
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
    } elseif ($action === 'landing') {
        issetSesionUser();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];  
            $error = $_SESSION['err'] ?? '';           
            $student->displayLanding($identifier, $error);
            $_SESSION['err'] = '';
        }
    } elseif($action === 'module'){
        issetSesionUser();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];       
            $admin->displayModules($identifier, $_POST);
        } else {
            $user->displayForm();
            die();              
        }
    } elseif ($action === 'rate') {
        issetSesionUser();
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
        issetSesionUser();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];
            $user->updatePassword($identifier);
        }
    } elseif ($action === 'updatePasswordForm') {
        issetSesionUser();
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            $identifier = $_GET['id'];
            $user->displayFormUpdatePassword($identifier);
        }
    } elseif ($action === 'updatePasswordTreatment') {
        issetSesionUser();
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
        issetSesionUser();
        $module_slug = $_GET['module_slug'] ?? '';
        $id = $_GET['id'] ?? '';
        if (isset($_POST)) {
            $rate->update_average($id, $module_slug, $_POST);
        }     
    } elseif ($action === 'insert') {
        issetSesionUser();
        $error = $_GET['error'] ?? '';
        $admin->displayInsert($error);         
    } elseif($action === 'insertStudent') {
        issetSesionUser();
        $data = $_POST ?? [];
        $admin->insertStudent($data);
    } elseif ($action === 'errorLogin') {
        issetSesionUser();
        $login_err = $_SESSION['err'];
        $user->displayForm($login_err);
        $_SESSION['err'] = ''; 
    } elseif ($action === 'errorPassword') {
        issetSesionUser();
        if (isset($_SESSION['err']) && isset($_GET['id']) && $_GET['id'] > 0) {
            $login_err = $_SESSION['err'];
            $identifier = $_GET['id'];
            $user->displayFormUpdatePassword($identifier, $login_err);
            $_SESSION['err'] = '';
        }      
    } elseif ($action === 'disconnect') {
        issetSesionUser();
        session_destroy();
        header('Location: index.php');
    } else {
        $user->displayForm();
        die();
    }
} else {
    $user->displayForm();
    die();
}

