<!-- Study -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer une filière</h1>
    <form action="<?= URL_ROOT ?>insertStudy" method="POST" class="form-group">
        <input type="text" name="name" id="name" placeholder="Nom de la filière (*)" class="form-control" required>
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <button onclick="resetTable(this)">Réinitialiser</button>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Filière</th>
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
$insert_study = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>