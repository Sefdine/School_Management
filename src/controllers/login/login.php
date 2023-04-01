<?php 

declare(strict_types=1);

namespace Ipem\Src\Controllers\Login;

use Ipem\Src\Model\User;

trait Login
{   
    public function displayForm(string $error = ''): void {
        require_once('templates/errors/errors.php');
        require_once('templates/login.php');
    }

    public function getConnect(string $identifier, string $password): void {
        if ($identifier === 'admin') {
            $_SESSION['name'] = 'admin';
        } else {
            $_SESSION['name'] = 'student';
        }
        $num = 0;        
        $users = new User;
        foreach($users->getUsers() as $user) {
            if(!is_null($user->identifier)) {
                if ($identifier === trim($user->identifier)) {
                    $user_password = $user->password;
                    if(is_null($user_password)) {
                        break;
                    } else {
                        if (password_verify($password, $user_password)) {
                            $num++;
                            $_SESSION['user_id'] = $user->id;
                            $_SESSION['user'] = $user->token;
                            break;
                        } else {
                            break;
                        }
                    }
                }
            } 
        }    

        if ($num > 0) {
            header('Location: ' .URL_ROOT. 'home');
        } else {
            $_SESSION['err'] = 'id_and_password';
            header('Location: '. URL_ROOT .'errorLogin');
        }
    }
}

