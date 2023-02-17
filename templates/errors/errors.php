<div class="container text-center">
<?php
switch($error)
{
    //Login error
    case 'id_and_password':
    ?>
        <div class="alert alert-danger">
            <strong>Erreur</strong> Identifiant et/ou mot de passe incorrect
        </div>
    <?php
    break;
    case 'already':
    ?>
        <div class="alert alert-danger">
            <strong>Erreur</strong> compte non existant
        </div>
    <?php
    break;
    case 'empty':
    ?>
        <div class="alert alert-danger">
            <strong>Erreur</strong> Case vide
        </div>
    <?php
    break;


    // Change password error
    case 'current_password':
        echo "<div class='alert alert-danger'>Le mot de passe actuel est incorrect</div>";
    break;

    case 'new_password':
        echo "<div class='alert alert-danger'>Le nouveau mot de passe ne doit pas être identique à l'actuelle</div>";
    break;

    case 'new_password_retype':
        echo "<div class='alert alert-danger'>Le nouveau mot de passe est incorrect</div>";
    break;

    case 'success_password':
        echo "<div class='alert alert-success'>Le mot de passe a bien été modifié ! </div>";
    break; 

    case 'problem':
        echo "<div class='alert alert-danger'>Votre mot de passe n'a pas pu être changé</div>";
    break; 

    //Rate error
    case 'empty_numInscription':
        echo "<div class='alert alert-danger'>Le champs numéro d'inscription est vide</div>";
    break;

    case 'rateSuccess':
        echo "<div class='alert alert-success'>La note a été ajoutée</div>";
    break;

    case 'rateError':
        echo "<div class='alert alert-danger'>La note n'a pas été ajoutée</div>";
    break;

    case 'invalid_num_inscription':
        echo "<div class='alert alert-danger'>Le numéro d'inscription n'existe pas ou l'étudiant n'est pas inscrit au groupe choisi</div>";
    break;

    //student landing error
    case 'rate_not_exist':
        echo "<div class='alert alert-danger'>Vos notes ne sont pas encore disponible</div>";
    break;
}
?> 

</div>

