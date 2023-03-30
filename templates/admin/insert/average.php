<!-- Average -->
<?php ob_start(); ?>
<div class="admin">
    <label for="study">Filière</label>
    <select name="study" id="study" onchange="select_study(this)" class="form-control">
        <?php foreach($studies as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $study) ? 'selected' : '' ?>><?= $item ?></option>
        <?php endforeach ?>
    </select>
    <label for="study">Group</label>
    <select name="group" id="group" onchange="select_group(this)" class="form-control">
        <?php foreach($groupes as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $group) ? 'selected' : '' ?>><?= $item ?></option>
        <?php endforeach ?>
    </select>
    <label for="study">Niveau</label>
    <select name="level" id="level" onchange="select_level(this)" class="form-control">
        <?php foreach($levels as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $level) ? 'selected' : '' ?>><?= ($item == 1) ? '1ère année' : '2ème année' ?></option>
        <?php endforeach ?>
    </select>
    <br>
    <hr>
    <form action="#" class="form-group">
            <table class="table table-light">
                <thead>
                    <th>#</th>
                    <th>Nom et prénom</th>
                    <th>Numéro d'inscription</th>
                    <th>Note</th>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach($data_users as $k => $line): ?>
                        <tr>
                            <td><?= $k+1 ?></td>
                            <td><?= $line->firstname .' '. $line->lastname ?></td>
                            <td><?= $line->identifier ?></td>
                            <td><input type="number" min="0" max="20"></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
    </form>
    <style>
        td, th {
            color: #000;
        }
        input {
            border: 1px solid blue;
            text-align: center;
            height: 30px;
        }
    </style>
</div>
<?php 
$insert_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>