
<?php ob_start(); ?>
<div id="text-center"> 
    <h3>M. <?= $user->firstname; ?> </h3>
</div>
<div class="container">
    Numéro d'inscription: <strong><?= $num_inscription ?></strong><br>
    Année: <strong><?= $year ?></strong><br>
    Filière: <strong><?= $study ?></strong><br>
    Groupe: <strong><?= $group ?></strong><br>
    Niveau: <strong><?= ($level === 1) ? '1ère année' : $level.'ème année' ?></strong><br>
    Contrôle: <strong><?= 'controle n°'.$control ?></strong>
    <div id="maTable">
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
                <th><?= $average ?></th>
            </tr>
        </table>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php') ?>

