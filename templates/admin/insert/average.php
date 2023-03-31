<!-- Average -->
<?php ob_start(); ?>
<div class="admin">
    <label for="group">Group</label>
    <select name="group" id="group" onchange="select_group(this)" class="form-control">
        <option value="title" disabled selected>Groupes</option>
        <?php foreach($groupes as $item): ?>
            <option value="<?= $item->slug ?>" <?= ($item->slug == $group) ? 'selected' : '' ?>><?= $item->name ?></option>
        <?php endforeach ?>
    </select>
    <label for="level">Niveau</label>
    <select name="level" id="level" onchange="select_level(this)" class="form-control">
        <option value="title" disabled selected>Niveaux</option>
        <?php foreach($levels as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $level) ? 'selected' : '' ?>><?= ($item == 1) ? '1ère année' : '2ème année' ?></option>
        <?php endforeach ?>
    </select>
    <label for="module">Modules</label>
    <select id="module" onchange="select_module(this)" class="form-control">
        <option value="title" disabled selected>Modules</option>
        <?php foreach($modules as $module): ?>
            <option value="<?= $module->slug ?>" <?= ($module->slug == $current_module) ? 'selected' : '' ?>><?= $module->name ?></option>
        <?php endforeach ?>
    </select>
    <hr>
    <form action="<?= URL_ROOT ?>insertAverages" method="post" class="form-group">
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
                        <td><?= ($k+1)+($currentPage-1)*10 ?></td>
                        <td><?= $line->firstname .' '. $line->lastname ?></td>
                        <td><?= $line->identifier ?></td>
                        <td><input type="number" step="0.1" name="<?= $line->identifier ?>" min="0" max="20"></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <input type="submit" onclick="submit_averages(this)" value="Insérer les notes" class="submit_average">
    </form>
    <div class="d-flex justify-content-between my-4">
        <?php if ($currentPage > 1): ?>
            <button class="btn btn-primary" onclick="previous_button_average(this)">&laquo; Précédant</button>
        <?php endif ?>
        <?php if ($currentPage < $pages): ?>
            <button class="btn btn-primary ml-auto" onclick="next_button_average(this)">Suivant &raquo;</button>
        <?php endif ?>
    </div>
</div>
<style>
        td, th {
            color: #000;
        }
        input {
            border: 1px solid blue;
            text-align: center;
            height: 30px;
        }
        .ml-auto {
            margin-left: auto;
        }
</style>
<script>let currentPage = <?= $currentPage ?></script>
<?php 
$insert_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>