<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers\Login;

use Ipem\Src\Model\User;

trait Login
{   
    public function displayForm(string $error = ''): void
    {
        require_once('templates/errors/errors.php');
        require_once('templates/login.php');
    }

    public function getConnect(string $radio, string $identifier, string $password): void
    {
        $num = 0;
        if ($radio === 'flexRadioDefault1') {          
            $users = new User;
            foreach($users->getUsers('student') as $user) {
                if ($identifier === $user->identifier && password_verify($password, $user->password)) {
                    $num++;
                    $identifier = $user->id;
                    $_SESSION['user'] = $user->token;
                    $_SESSION['name'] = 'student';
                }
            }         
        } elseif ($radio === 'flexRadioDefault2') {
            $users = new User;
            foreach($users->getUsers('teacher') as $user) {
                if ($identifier === $user->identifier && password_verify($password, $user->password)) {
                    $num++;
                    $identifier = $user->id;
                    $_SESSION['user'] = $user->token;
                    $_SESSION['name'] = 'teacher';
                }
            }
        }

        if ($num) {
            header('Location: index.php?action=home&id=' .$identifier);
        } else {
            header('Location: index.php?action=errorLogin&login_err=id_and_password');
        }
    }
}

