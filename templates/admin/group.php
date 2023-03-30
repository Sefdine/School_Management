<!-- Group -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer un group</h1>
    <form action="<?= URL_ROOT ?>insertGroup" method="post" class="form-group">
        <input type="text" name="name" id="name" placeholder="Nom du groupe (*)" class="form-control" required>
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <button onclick="resetTable(this)">Réinitialiser</button>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Groupe</th>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach($data as $k => $line): ?>
            <tr>
                <td><?= $k+1 ?></td>
                <td><?= $line ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php 
$insert_group = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>