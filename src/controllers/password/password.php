<?php

declare(strict_types=1);

namespace Ipem\Src\Controllers\Password;

use Ipem\Src\Model\User;

trait Password
{
    public function displayFormUpdatePassword(string $identifier, string $error = ''): void
    {
        $title = 'Changer mon mot de passe';
        require_once('templates/errors/errors.php');
        require_once('templates/password/update_password_form.php');
    }

    public function updatePasswordTreatment(string $identifier, string $current_password, string $new_password): void
    {
        $users = new User;
        $user = $users->getUser($identifier);
        if ($current_password !== $new_password) {
            if (password_verify($current_password, $user->password)) {
                $cost = ['cost' => 12];
                $new_password = password_hash($new_password, PASSWORD_BCRYPT, $cost);
                $success = $users->setPassword($identifier, $new_password);
    
                if ($success) {
                    $_SESSION['err'] = 'success_password';
                    header('Location: '. URL_ROOT .'errorPassword/'.$identifier);
                } else {
                    $_SESSION['err'] = 'problem';
                    header('Location: '. URL_ROOT .'errorPassword/'.$identifier);
                }
            } else {
                $_SESSION['err'] = 'current_password';
                header('Location: '. URL_ROOT .'errorPassword/'.$identifier);
            }
        } else {
            $_SESSION['err'] = 'new_password';
            header('Location: '. URL_ROOT .'errorPassword/'.$identifier);
        }
    }

    public function updatePassword(string $identifier): void
    {
        $users = new User;
        $title = 'Changer mon mot de passe';
        $user = $users->getUser($identifier);
        require_once('templates/password/update_password.php');
    }
}
