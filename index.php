<?php

declare(strict_types=1);

use Ipem\Src\Controllers\Student;
use Ipem\Src\Controllers\Teacher;
use Ipem\Src\Controllers\User;
use Ipem\Src\Controllers\Average;

require_once('config/config.php');

session_start();

spl_autoload_register(static function(string $fqcn) {
    $path = substr_replace(strtolower(str_replace(['\\', 'Ipem'], ['/', ''], $fqcn)), '', 0, 1).'.php';
    require_once($path);
});

$student = new Student;
$teacher = new Teacher;
$user = new User;
$rate = new Average;

if (isset($_GET['action'])){
    $action = $_GET['action'];
    if ($action === 'connectionTreatment') {
        if (isset($_POST['flexRadioDefault']) && !empty($_POST['identifier']) && !empty($_POST['password'])) {
            $radio = $_POST['flexRadioDefault'];
            $identifier = $_POST['identifier'];
            $password = $_POST['password'];
            $user->getConnect($radio, $identifier, $password);
        } else {
            header('Location: index.php?action=errorLogin&login_err=empty');
        }

    } elseif ($action === 'home') {
        if (isset($_SESSION['user'])) {
            $name = $_SESSION['name'] ?? '';
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];             
                if ($name === 'student') {
                    $student->displayHome($identifier);
                } elseif ($name === 'teacher') {
                    $teacher->displayLanding($identifier);
                } else {
                    $user->displayForm();
                    die();
                }
            }
        } else {
            $user->displayForm();
            die();
        }
    } elseif ($action === 'landing') {
        if (isset($_SESSION['user'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];  
                $error = $_SESSION['err'] ?? '';           
                $student->displayLanding($identifier, $error);
                $_SESSION['err'] = '';
            }
        } else {
            $user->displayForm();
            die();
        }
    } elseif($action === 'module'){
        if (isset($_SESSION['user'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];       
                $teacher->displayModules($identifier, $_POST);
            } else {
                $user->displayForm();
                die();              
            }
        } else {
            $user->displayForm();
            die();
        }
    }elseif ($action === 'rate') {
        if (isset($_SESSION['user'])) {
            $name = $_SESSION['name'] ?? '';
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                if ($name === 'student') {
                    $year = $_POST['year'] ?? '';
                    $control = $_POST['control'] ?? '';
                    $student->displayAverage($identifier, $year, $control);
                } elseif ($name === 'teacher') {                
                    $module_slug = $_GET['module_slug'] ?? '';
                    $error = $_SESSION['err'] ?? '';
                    $data = $_SESSION['array'] ?? '';
                    if(isset($_SESSION['sessionData']) && $_SESSION['sessionData'] > 0){
                        $_SESSION['data'] = [];
                    }
                    $teacher->displayFormRate($identifier, $module_slug, $data, $error);
                    $user->displayForm();
                    $_SESSION['err'] = '';
                    die();
                }
            }
        } else {
            $user->displayForm();
            die();
        }
    } elseif ($action === 'updatePassword') {
        if (isset($_SESSION['user'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                $user->updatePassword($identifier);
            }
        } else {
            $user->displayForm();
            die();
        }
    } elseif ($action === 'updatePasswordForm') {
        if (isset($_SESSION['user'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                $user->displayFormUpdatePassword($identifier);
            }
        } else {
            $user->displayForm();
            die();
        }   
    } elseif ($action === 'updatePasswordTreatment') {
        if (isset($_SESSION['user'])) {
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
        } else {
            $user->displayForm();
            die();
        }   
    } elseif ($action === 'rateTreatment') {
        if (isset($_SESSION['user'])) {
            $module_slug = $_GET['module_slug'] ?? '';
            $id = $_GET['id'] ?? '';
            if (isset($_POST)) {
                $rate->update_average($id, $module_slug, $_POST);
            }
        } else {
            $teacher->displayForm();
            die();
        }          
    } elseif ($action === 'inputRates') {
        if (isset($_SESSION['user'])) {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                //$teacher->displayFormRate($identifier);
            } 
        } else {
            $teacher->displayForm();
            die();
        }          
    } elseif ($action === 'errorLogin') {
        if (isset($_SESSION['err'])) {
            $login_err = $_SESSION['err'];
            $user->displayForm($login_err);
            $_SESSION['err'] = '';
        }    
    } elseif ($action === 'errorPassword') {
        if (isset($_SESSION['user'])) {
            if (isset($_SESSION['err']) && isset($_GET['id']) && $_GET['id'] > 0) {
                $login_err = $_SESSION['err'];
                $identifier = $_GET['id'];
                $user->displayFormUpdatePassword($identifier, $login_err);
                $_SESSION['err'] = '';
            }
        } else {
            $user->displayForm();
            die();
        }        
    } elseif ($action === 'disconnect') {
        if (isset($_SESSION['user'])) {
            session_destroy();
            header('Location: index.php');
        } 
    } else {
        $user->displayForm();
        die();
    }
} else {
    $user->displayForm();
}

