
<?php ob_start(); ?>
<div id="text-center"> 
    <h3>M. <?= $user->firstname; ?> </h3>
</div>

<div id="maTable" class="container">
    <table >
        <tr id="headerline">
            <th>Modules</th>
            <th>Notes</th>
        </tr>
        <tr> 
            <td id="firstcolumn">Français</td>
            <td id="secondcolumn"><?= $rate->french ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Anglais</td>
            <td id="secondcolumn"><?= $rate->english ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Action Commerciale</td>
            <td id="secondcolumn"><?= $rate->marketing ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Comptabilité Général</td>
            <td id="secondcolumn"><?= $rate->accounting ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Bureautique</td>
            <td id="secondcolumn"><?= $rate->office ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Statistique</td>
            <td id="secondcolumn"><?= $rate->statistics ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Gestion de l'entreprise</td>
            <td id="secondcolumn"><?= $rate->business_management ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Gestion administrative</td>
            <td id="secondcolumn"><?= $rate->admin_management ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Legislation du travail</td>
            <td id="secondcolumn"><?= $rate->work_legislation ?></td>
        </tr>
        <tr> 
            <td id="firstcolumn">Mathématique Financière</td>
            <td id="secondcolumn"><?= $rate->financial_math ?></td>
        </tr>
        <tr id="footerline">
            <th>Moyenne</th>
            <th><?= $average ?></th>
        </tr>
    </table>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templates/layout.php') ?>

