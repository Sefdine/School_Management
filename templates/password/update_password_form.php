
<?php ob_start() ?>

<br>
<div class="container modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Changer mon mot de passe</h5>
        </div>
        <div class="modal-body">
            <form action="<?= URL_ROOT ?>updatePasswordTreatment/<?= $identifier ?>" method="POST">
                <label for='current_password'>Mot de passe actuel</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required />
                <br />
                <label for='new_password'>Nouveau mot de passe</label>
                <input type="password" id="new_password" name="new_password" class="form-control" required />
                <br />
                <label for='new_password_retype'>Re tapez le nouveau mot de passe</label>
                <input type="password" id="new_password_retype" name="new_password_retype" class="form-control" required />
                <br />
                <button type="submit" class="btn btn-success">Sauvegarder</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" onclick="window.location.href='<?= URL_ROOT ?>updatePassword/<?= $identifier ?>';" class="btn btn-danger" data-dismiss="modal">Fermer</button>
        </div>
    </div>
</div>

<?php $content = ob_get_clean() ?>

<?php require_once('templates/layout.php') ?>

