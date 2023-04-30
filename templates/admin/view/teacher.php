<?php ob_start(); ?>
<div class="p-4">
    <div id="radioGroupes">
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
    <table class="table table-dark table-striped">
        <thead>
            <th>Noms</th>
            <th>Prenoms</th>
        </thead>
        <tbody>
            <?php foreach($firstname_lastname as $item): ?>
            <tr>
                <td><?= $item->firstname ?></td>
                <td><?= $item->lastname ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>

<?php 
$insert_teacher = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>