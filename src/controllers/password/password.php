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

    public function updatePasswordTreatment(string $name, string $identifier, string $current_password, string $new_password): void
    {
        $users = new User;
        $user = $users->getUser($name, $identifier);
        if ($current_password !== $new_password) {
            if (password_verify($current_password, $user->password)) {
                $cost = ['cost' => 12];
                $new_password = password_hash($new_password, PASSWORD_BCRYPT, $cost);
                $success = $users->setPassword($name, $identifier, $new_password);
    
                if ($success) {
                    header('Location: index.php?action=errorPassword&login_err=success_password&id='.$identifier);
                } else {
                    header('Location: index.php?action=errorPassword&login_err=problem&id='.$identifier);
                }
            } else {
                header('Location: index.php?action=errorPassword&login_err=current_password&id='.$identifier);
            }
        } else {
            header('Location: index.php?action=errorPassword&login_err=new_password&id='.$identifier);
        }
    }

    public function updatePassword(string $name, string $identifier): void
    {
        $users = new User;
        $title = 'Changer mon mot de passe';
        $user = $users->getUser($name, $identifier);
        require_once('templates/password/update_password.php');
    }
}
