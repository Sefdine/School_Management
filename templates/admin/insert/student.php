<!-- Student -->
<?php ob_start() ?>
<div class="admin">
    <h1>Insérer un étudiant</h1>
    <form action="<?= URL_ROOT ?>insertStudent" method="post" class="form-group">
        <input type="text" name="lastname" id="lastname" placeholder="Nom *" class="form-control" required>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom *" class="form-control" required>
        <input type="text" name="identifier" id="identifier" placeholder="Numéro d'inscription *" class="form-control" required>
        <input type="text" name="nationality" id="nationality" placeholder="Nationalité *" class="form-control" required>
        <input type="date" name="birthday" id="birthday" placeholder="Date de naissance" class="form-control">
        <input type="text" name="cin" id="cin" placeholder="Numéro CIN" class="form-control">
        <input type="text" name="address" id="address" placeholder="Adresse" class="form-control">
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
            <th>Numéro d'insription</th>
            <th>Nationalité</th>
            <th>Date de naissance</th>
            <th>CIN</th>
            <th>Adresse</th>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach($data as $k => $line): ?>
            <tr class="tr_student">
                <td><?= $k+1 ?></td>
                <td><?= $line['lastname'] ?></td>
                <td><?= $line['firstname'] ?></td>
                <td><?= $line['identifier'] ?></td>
                <td><?= $line['nationality'] ?></td>
                <td><?= $line['birthday'] ?></td>
                <td><?= $line['cin'] ?></td>
                <td><?= $line['address'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php 
$insert_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>