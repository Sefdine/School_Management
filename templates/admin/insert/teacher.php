<!-- Teacher -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer un enseignant</h1>
    <form action="<?= URL_ROOT ?>insertTeacher" method="post" class="form-group">
        <input type="text" name="lastname" id="lastname" placeholder="Nom *" class="form-control" required>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom *" class="form-control" required>
        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
        <input type="text" name="tel" id="tel" placeholder="Numéro GSM" class="form-control">
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
<?php 
$insert_teacher = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>