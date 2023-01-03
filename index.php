<?php

declare(strict_types=1);

use Ipem\Src\Controllers\Student;
use Ipem\Src\Controllers\Teacher;
use Ipem\Src\Controllers\User;
use Ipem\Src\Controllers\Rate;

session_start();

spl_autoload_register(static function(string $fqcn) {
    $path = substr_replace(strtolower(str_replace(['\\', 'Ipem'], ['/', ''], $fqcn)), '', 0, 1).'.php';
    require_once($path);
});

$student = new Student;
$teacher = new Teacher;
$user = new User;
$rate = new Rate;

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
                    $teacher->displayHome($identifier);
                } else {
                    $user->displayForm();
                    die();
                }
            }
        } else {
            $user->displayForm();
            die();
        }
    } elseif ($action === 'rate') {
        if (isset($_SESSION['user'])) {
            $name = $_SESSION['name'] ?? '';
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                if ($name === 'student') {
                    $student->displayRate($identifier);
                } elseif ($name === 'teacher') {                    
                    $module = $_GET['module'] ?? '';
                    $error = $_GET['error'] ?? '';
                    if(isset($_GET['sessionData']) && $_GET['sessionData'] > 0){
                        $_SESSION['data'] = [];
                    }
                    $teacher->displayFormRate($identifier, $module, $error);
                } else {
                    $user->displayForm();
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
                $name = $_SESSION['name'] ?? '';
                $user->updatePassword($name, $identifier);
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
            $name = $_SESSION['name'] ?? '';
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $identifier = $_GET['id'];
                $current_passord = $_POST['current_password'];
                $new_password = $_POST['new_password'];
                $new_password_retype = $_POST['new_password_retype'];
                if ($new_password === $new_password_retype) {
                   $user->updatePasswordTreatment($name, $identifier, $current_passord, $new_password);
                } else {
                    header('Location: index.php?action=errorPassword&login_err=new_password_retype&id='.$identifier);
                }
            }
        } else {
            $user->displayForm();
            die();
        }   
    } elseif ($action === 'rateTreatment') {
        if (isset($_SESSION['user'])) {
            $module = $_GET['module'] ?? '';
            $id = $_GET['id'] ?? '';
            if (isset($_POST)) {
                $rate->update_rate($id, $module, $_POST);
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
        if (isset($_GET['login_err'])) {
            $login_err = $_GET['login_err'];
            $user->displayForm($login_err);
        }    
    } elseif ($action === 'errorPassword') {
        if (isset($_SESSION['user'])) {
            if (isset($_GET['login_err']) && isset($_GET['id']) && $_GET['id'] > 0) {
                $login_err = $_GET['login_err'];
                $identifier = $_GET['id'];
                $user->displayFormUpdatePassword($identifier, $login_err);
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

