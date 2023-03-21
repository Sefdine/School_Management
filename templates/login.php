
<?php ob_start(); ?>
<div class="login-form">
    <img src="public/images/logo_ipem1.JPG" alt="Logo de IPEM" id="logo_ipem">
    <form action="<?= URL_ROOT ?>connectionTreatment" method="post">
        <h2 class="text-center">Connexion</h2>
        <div class="form-group">
            <input type="text" name="identifier" class="form-control" placeholder="Identifiant" required="required" autocomplete="off">
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required="required" autocomplete="off">
        </div>
        <div class="form-group" style="margin-top: 20px; text-align: center;">
            <button type="submit" class="btn btn-primary btn-block">Connexion</button>
        </div>
    </form>

</div>

<?php $content = ob_get_clean(); ?>
<?php 
    require_once('templates/layout.php'); 
?>

