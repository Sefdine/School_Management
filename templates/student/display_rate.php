
<?php ob_start(); ?>

<div class="section_display_average_student">
    <h1>Ravi de vous voir</h1>
    <label>
        <strong><?= $user->firstname. ' '. $user->lastname ?></strong><br>
        Numéro d'inscription: <strong><?= $num_inscription ?></strong><br>
        Année: <strong><?= $year ?></strong><br>
        Filière: <strong><?= $study ?></strong><br>
        Groupe: <strong><?= $group ?></strong><br>
        Type d'examen: <strong><?= $type_exam ?></strong><br>
        Examen: <strong><?= $exam ?></strong>
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
                <th>Notes</th>
            </tr>
            <?php foreach($data as $module => $rate): ?>
            <tr> 
                <td id="firstcolumn"><?= $module ?></td>
                <td id="secondcolumn"><?= $rate ?></td>
            </tr>
            <?php endforeach ?>
            <tr id="footerline">
                <th>Moyenne</th>
                <th><?= (count($data) == 10) ? $average : 'NI'?></th>
            </tr>
        </table>
    </div>
</div>   

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php') ?>

