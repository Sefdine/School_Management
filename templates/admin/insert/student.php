<!-- Student -->
<?php ob_start() ?>
<div class="admin">
    <h1>Insérer un étudiant</h1>
    <form action="<?= URL_ROOT ?>insertStudent" method="post" class="form-group">
    <div class="input-group">
        <span class="input-group-text">Nom *</span>
        <input type="text" name="lastname" id="lastname" class="form-control" required>
    </div>
    <div class="input-group">
        <span class="input-group-text">Prénom *</span>
        <input type="text" name="firstname" id="firstname" class="form-control" required>
    </div>
    <div class="input-group">
        <span class="input-group-text">Lieu de naissance</span>
        <input type="text" name="place_birth" id="place_birth" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Date de naissance</span>
        <input type="date" name="birthday" id="birthday" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Numéro d'inscription</span>
        <input type="text" name="identifier" id="identifier" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Date d'inscription</span>
        <input type="date" name="registration_date" id="registration_date" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Nationalité</span>
        <input type="text" name="nationality" id="nationality" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">CIN ou passeport</span>
        <input type="text" name="cin" id="cin" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Genre</span>
        <select name="gender" id="gender" class="form-select">
            <option value="male">M</option>
            <option value="female">F</option>
        </select>
    </div>
    <div class="input-group">
        <span class="input-group-text">Adresse</span>
        <input type="text" name="address" id="address" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Niveau</span>
        <input type="text" name="level_study" id="level_study" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Date d'entrée au Maroc</span>
        <input type="date" name="entry_date" id="entry_date" class="form-control">
    </div>
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
</div>
<style>
    .input-group-text {
        width: 30%;
    }
</style>
<?php 
$insert_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>