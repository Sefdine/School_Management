<!-- Student -->
<?php ob_start() ?>
<div class="admin">
    <h1>Insérer un étudiant</h1>
    <form action="<?= URL_ROOT ?>insertStudent" method="post" class="form-group">
        <input type="text" name="lastname" id="lastname" placeholder="Nom *" class="form-control" required>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom *" class="form-control" required>
        <input type="text" name="identifier" id="identifier" placeholder="Numéro d'inscription *" class="form-control" required>
        <input type="text" name="nationality" id="nationality" placeholder="Nationalité *" class="form-control" required>
        <input type="date" name="birthday" id="birthday" placeholder="Date de naissance" class="form-control">
        <input type="text" name="cin" id="cin" placeholder="Numéro CIN" class="form-control">
        <input type="text" name="address" id="address" placeholder="Adresse" class="form-control">
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Numéro d'insription</th>
            <th>Nationalité</th>
            <th>Date de naissance</th>
            <th>CIN</th>
            <th>Adresse</th>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach($data_student as $line): ?>
            <tr>
                <td>1</td>
                <td><?= $line['lastname'] ?></td>
                <td><?= $line['firstname'] ?></td>
                <td><?= $line['identifier'] ?></td>
                <td><?= $line['nationality'] ?></td>
                <td><?= $line['birthday'] ?></td>
                <td><?= $line['cin'] ?></td>
                <td><?= $line['address'] ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>
<?php 
$insert_student = ob_get_clean(); 
?>

<!-- Teacher -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer un enseignant</h1>
    <form action="#" method="post" class="form-group">
        <input type="text" name="lastname" id="lastname" placeholder="Nom *" class="form-control" required>
        <input type="text" name="firstname" id="firstname" placeholder="Prénom *" class="form-control" required>
        <input type="text" name="email" id="email" placeholder="Email" class="form-control">
        <input type="text" name="tel" id="tel" placeholder="Numéro GSM" class="form-control">
        <input type="text" name="cin" id="cin" placeholder="Numéro CIN" class="form-control">
        <input type="text" name="address" id="address" placeholder="Adresse" class="form-control">
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Tél</th>
            <th>CIN</th>
            <th>Adresse</th>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <td>1</td>
                <td>John</td>
                <td>Doe</td>
                <td>joh@doe.com</td>
                <td>06 15 34 56 23</td>
                <td>KL897M</td>
                <td>44 New york, United State</td>
            </tr>
            <tr>
            <td>1</td>
                <td>John</td>
                <td>Doe</td>
                <td>joh@doe.com</td>
                <td>06 15 34 56 23</td>
                <td>KL897M</td>
                <td>44 New york, United State</td>
            </tr>
        </tbody>
    </table>
</div>
<?php 
$insert_teacher = ob_get_clean(); 
?>

<!-- Study -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer une filière</h1>
    <form action="#" method="post" class="form-group">
        <input type="text" name="name" id="name" placeholder="Nom de la filière (*)" class="form-control" required>
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Année</th>
            <th>Filière</th>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <td>1</td>
                <td>2022</td>
                <td>Gestion de l'entreprise</td>
            </tr>
            <tr>
                <td>2</td>
                <td>2023</td>
                <td>Gestion de l'entreprise</td>
            </tr>
        </tbody>
    </table>
</div>
<?php 
$insert_study = ob_get_clean(); 
?>

<!-- Group -->
<?php ob_start(); ?>
<div class="admin">
    <h1>Insérer un group</h1>
    <form action="#" method="post" class="form-group">
        <select name="study" id="study" class="form-control">
            <option value="gestion">Gestion de l'entreprise</option>
            <option value="info">Informatique</option>
        </select>
        <input type="text" name="name" id="name" placeholder="Nom du groupe (*)" class="form-control" required>
        <input type="submit" value="Insérer" class="btn btn-primary">
    </form>
    <br>
    <hr>
    <h3>Champs ajoutés</h3>
    <table class="table table-dark">
        <thead>
            <th>#</th>
            <th>Filière</th>
            <th>Groupe</th>
        </thead>
        <tbody class="table-group-divider">
            <tr>
                <td>1</td>
                <td>Gestion de l'entreprise</td>
                <td>Technicien</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Gestion de l'entreprise</td>
                <td>Technicien Spécialisé</td>
            </tr>
        </tbody>
    </table>
</div>
<?php 
$insert_group = ob_get_clean(); 
?>

<!-- Level -->
<?php ob_start(); ?>
<div class="admin">

</div>
<?php 
$insert_level = ob_get_clean(); 
?>

<!-- Average -->
<?php ob_start(); ?>
<div class="admin">

</div>
<?php 
$insert_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>