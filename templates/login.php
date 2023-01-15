
<?php ob_start(); ?>
<div class="login-form">
    <img src="public/images/logo_ipem1.jpg" alt="Logo de IPEM" id="logo_ipem">
    <form action="index.php?action=connectionTreatment" method="post">
        <h2 class="text-center">Connexion</h2>
        <div style="display: flex; flex-direction: row;">
            <div class="form-check" style="margin-left:20px">
                <input class="form-check-input" type="radio" name="flexRadioDefault" value="flexRadioDefault1" required="required">
                <label class="form-check-label" for="flexRadioDefault1" style="color: rgb(39, 39, 43);">
                    Etudiant
                </label>
            </div>
            <div class="form-check" style="margin-left:70px">
                <input class="form-check-input" type="radio" name="flexRadioDefault" value="flexRadioDefault2" required="required">
                <label class="form-check-label" for="flexRadioDefault2" style="color: rgb(39, 39, 43);">
                    Professeur
                </label>
            </div>
        </div>


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
    <p class="text-center">Si vous rencontrez un problème suite à votre identification, renseigner vous auprès de l'administration ! </p>

</div>

<?php $content = ob_get_clean(); ?>
<?php 
    require_once('templates/layout.php'); 
?>

