
<?php ob_start(); ?>

<div class="section_display_average_student">
    <h1>Ravi de vous voir</h1>
    <label>
        <strong><?= $user->firstname. ' '. $user->lastname ?></strong><br>
        Numéro d'inscription: <strong><?= $num_inscription ?></strong><br>
        Année: <strong><?= $year ?></strong><br>
        Filière: <strong><?= $study ?></strong><br>
        Groupe: <strong><?= ($group == 1) ? '1ère année' : '2ème année' ?></strong><br>
        <?= ($exam_type == 'Examen') ? 'Examen' : 'Contrôle' ?>: <strong><?= $exam_name ?></strong><br>
        </label>
</div>
<div class="display_average_student">
    <div class="col_display_average_student">
        <p>Les notes qui s'afficheront sont celles publiées par vos enseignants.<br>
        La moyenne s'affichera lorsque toutes les notes seront au complet sinon elle affichera <strong>"NI"</strong> pour <strong>"Notes Incomplètes"</strong></p>
    </div>
    <div id="myTable">
        <table >
            <tr id="headerline">
                <th>Modules</th>
                <th>Coefficients</th>
                <th>Notes</th>
                <th>C x N</th>
            </tr>
            <?php foreach($rates as $item): ?>
            <tr> 
                <td id="firstcolumn"><?= $item->name_module ?></td>
                <td id="secondcolumn"><?= $item->factor ?></td>
                <td id="firstcolumn"><?= $item->value_average ?></td>
                <td id="secondcolumn"><?= $item->value_average * $item->factor ?></td>
            </tr>
            <?php endforeach ?>
            <?php if (count($rates) == $total_module): ?>
            <tr id="headerline">
                <th>Total</th>
                <th><?= $total_factor ?></th>
                <th><?= $total_average ?></th>
                <th><?= $total_factor_average ?></th>
            </tr>
            <?php endif ?>
            <tr id="footerline">
                <th colspan="2">Moyenne</th>
                <th><?= (count($rates) == $total_module) ? round($average, 2) : 'NI'?></th>
            </tr>
        </table>
    </div>
</div>   

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php') ?>

