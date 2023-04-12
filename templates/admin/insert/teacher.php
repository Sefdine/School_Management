<!-- Teacher -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer un enseignant</h1>
    <form action="<?= URL_ROOT ?>insertTeacher" method="post" class="form-group">
    <div class="input-group">
        <span class="input-group-text">Nom *</span>
        <input type="text" name="lastname" id="lastname" class="form-control" required>
    </div>
    <div class="input-group">
        <span class="input-group-text">Prénom *</span>
        <input type="text" name="firstname" id="firstname" class="form-control" required>
    </div>
    <div class="input-group">
        <span class="input-group-text">Email</span>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">GSM</span>
        <input type="text" name="tel" id="tel" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">CIN</span>
        <input type="text" name="cin" id="cin" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Adresse</span>
        <input type="text" name="address" id="address" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Diplome</span>
        <input type="text" name="degree" id="degree" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Expérience</span>
        <input type="number" name="experience" id="experience" class="form-control">
    </div>
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
</div>
<style>
    .input-group-text {
        width: 20%;
    }
</style>
<?php 
$insert_teacher = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>