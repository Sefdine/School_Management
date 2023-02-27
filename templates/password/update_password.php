
<?php ob_start(); ?>
<div class="container">
    <div class="col-md-12"> 
        <div class="text-center">
            <h1 class="p-5">M. <?= $user->firstname; ?> !</h1>
            <hr />
            <p>Cliquez sur le boutton ci-dessous pour changer votre mot de passe</p>
            <button type="button" onclick="window.location.href = '<?= URL_ROOT ?>updatePasswordForm/<?= $user->id ?>';" class="btn btn-info btn-lg" data-toggle="modal" data-target="#change_password">
                Changer mon mot de passe
            </button>
            <br>
            <br>
            <a href="<?= URL_ROOT ?>home/<?=  $user->id ?>">Retour à l'accueil</a>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('templates/layout.php'); ?>