<!-- Teacher -->
<?php ob_start(); ?>
<div class="admin">
    <div class="row">
        <div id="radioGroupes" class="col-md-4 ms-4">
            <h3>Choisissez un groupe</h3>
            <div class="form-check">
                <input type="radio" name="groupRadio" id="firstYear" class="form-check-input" value="1" <?= ($group == 1) ? 'checked' : '' ?>>
                <label for="firstYear" class="form-check-label">1ère année</label>
            </div>
            <div class="form-check">
                <input type="radio" name="groupRadio" id="secondYear" class="form-check-input" value="2" <?= ($group == 2) ? 'checked' : '' ?>>
                <label for="secondYear" class="form-check-label">2ème année</label>
            </div>
        </div>
        <div class="col-md-6 ms-3" id="modulesTeacherCheckbox">
            <h3>Choisissez un module</h3>
            <?php foreach($modules as $module): ?>
                <div class="form-check">
                    <input type="checkbox" name="moduleCheckbox" id="<?= $module->slug ?>" value="<?= $module->slug ?>" class="form-check-input">
                    <label for="<?= $module->slug ?>" class="form-check-label"><?= $module->name ?></label>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <h1>Insérer un enseignant</h1>
    <div class="form-group">
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
        <input type="submit" value="Insérer" class="btn btn-primary" onclick="insert_teacher_btn(this)">
    </div>
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