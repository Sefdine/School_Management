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
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <button onclick="resetTable(this)">Réinitialiser</button>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Tél</th>
            <th>CIN</th>
            <th>Adresse</th>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach($data as $k => $line): ?>
            <tr>
                <td><?= $k+1 ?></td>
                <td><?= $line['lastname'] ?></td>
                <td><?= $line['firstname'] ?></td>
                <td><?= $line['email'] ?></td>
                <td><?= $line['tel'] ?></td>
                <td><?= $line['cin'] ?></td>
                <td><?= $line['address'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
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