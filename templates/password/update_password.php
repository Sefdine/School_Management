
<?php ob_start(); ?>
<div class="container">
    <div class="col-md-12"> 
        <div class="text-center">
            <h1 class="p-5">Bonjour M. <?= $user->firstname; ?> !</h1>
            <hr />
            <p>Cliquez sur le boutton ci-dessous pour changer votre mot de passe</p>
            <button type="button" onclick="window.location.href = 'index.php?action=updatePasswordForm&id=<?= urldecode($user->id)?>';" class="btn btn-info btn-lg" data-toggle="modal" data-target="#change_password">
                Changer mon mot de passe
            </button>
            <br>
            <br>
            <a href="index.php?action=home&id=<?=  urldecode($user->id) ?>">Retour à l'accueil</a>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php'); ?>