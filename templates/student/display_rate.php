
<?php ob_start(); ?>

<div class="section_display_average_student">
    <h1>Ravi de vous voir</h1>
    <label>
        <strong><?= $user->firstname. ' '. $user->lastname ?></strong><br>
        Numéro d'inscription: <strong><?= $num_inscription ?></strong><br>
        Année: <strong><?= $year ?></strong><br>
        Filière: <strong><?= $study ?></strong><br>
        Groupe: <strong><?= ($group == 1) ? '1ère année' : '2ème année' ?></strong><br>
        <?php if ($exam_type != 'Examen'): ?>
            <?= ($exam_type == 'Examen') ? 'Examen' : 'Contrôle' ?>: <strong><?= $exam_name ?></strong><br>
        <?php endif ?>
    </label>
</div>
<div class="display_average_student">
    <div class="col_display_average_student">
        <label>MCC: Moyenne des contrôles continus</label><br>
        <label>MEFCFT: Moyenne Examen Finale Théorique</label><br>
        <label>MEFCFP: Moyenne Examen Finale Pratique</label><br>
        <p>Les notes qui s'afficheront sont celles publiées par vos enseignants.<br>
        La moyenne s'affichera lorsque toutes les notes seront au complet sinon elle affichera <strong>"NI"</strong> pour <strong>"Notes Incomplètes"</strong></p>
    </div>
    <div id="myTable" class="releveExamStudent container">
        <?php if ($exam_type == 'Examen'): ?>
            <table >
                <tr id="headerline">
                    <th>Modules</th>
                    <th>Coeff.</th>
                    <th>MCC</th>
                    <th>MEFCFT</th>
                    <th>MEFCFP</th>
                </tr>
                <?php foreach($averages as $item): ?>
                <tr> 
                    <td id="firstcolumn"><?= $item->name_module ?></td>
                    <td id="secondcolumn"><?= $item->factor ?></td>
                    <td id="firstcolumn"><?= $item->controles ?></td>
                    <td id="secondcolumn"><?= $item->theorical ?></td>
                    <td id="firstcolumn"><?= $item->pratical ?></td>
                </tr>
                <?php endforeach ?>
                <?php if (count($averages) == $total_module): ?>
                <tr id="headerline">
                    <th>Total</th>
                    <th><?= $total_factor ?></th>
                    <th><?= $total_controls ?></th>
                    <th><?= $total_exam_theorical ?></th>
                    <th><?= $total_exam_pratical?></th>
                </tr>
                <tr id="footerline">
                    <th colspan="2">Moyenne Générale</th>
                    <th><?= $ga_controls ?></th>
                    <th><?= $ga_exam_theorical ?></th>
                    <th><?= $ga_exam_pratical ?></th>
                </tr>
                <?php endif ?>
                <tr id="headerline">
                    <th colspan="2">Moyenne Finale</th>
                    <th><?= (count($averages) == $total_module) ? round($final_average, 2) : 'NI'?></th>
                </tr>
            </table>
        <?php else: ?>
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
        <?php endif ?>
    </div>
</div>   

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php') ?>

