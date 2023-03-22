
<?php ob_start(); ?>
<div class="header_dashboard">
    <h2 class="logo_admin">Mon logo</h2>
    <ul class="nav_top">
        <li><a href="#">Home</a></li>
        <li><a href="#" class="nav_insert">Insert</a></li>
        <li><a href="#" class="nav_update">Update</a></li>
        <li><a href="#" class="nav_delete">Delete</a></li>
    </ul>
    <a href="#" class="year_admin">Year</a>
    <a href="#" class="sign_out">Sign out</a>
</div>
<div class="section_admin">
    <div class="nav_left">
        <ul>
            <li><a href="#">Etudiants</a></li>
            <li><a href="#">Enseignants</a></li>
            <li><a href="#">Filières</a></li>
            <li><a href="#">Groupes</a></li>
            <li><a href="#">Niveau</a></li>
            <li><a href="#">Notes</a></li>
        </ul>
    </div>
    <div class="contain_admin">
        <div class="container">
            <div class="admin_home">
                <h1>Insérer un étudiant</h1>
                <form action="#" method="post" class="form-group">
                    <input type="text" name="lastname" id="lastname" placeholder="Nom" class="form-control">
                    <input type="text" name="firstname" id="firstname" placeholder="Prénom" class="form-control">
                    <input type="text" name="identifier" id="identifier" placeholder="Numéro d'inscription" class="form-control">
                    <input type="text" name="nationality" id="nationality" placeholder="Nationalité" class="form-control">
                    <input type="text" name="birthday" id="birthday" placeholder="Date de naissance" class="form-control">
                    <input type="text" name="cin" id="cin" placeholder="Numéro CIN" class="form-control">
                    <input type="text" name="address" id="address" placeholder="Adresse" class="form-control">
                    <input type="submit" value="Insérer" class="btn btn-primary">
                </form>
                <br>
                <hr>
                <h3>Data</h3>
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
                        <tr>
                            <td>1</td>
                            <td>John</td>
                            <td>Doe</td>
                            <td>GE334</td>
                            <td>Américaine</td>
                            <td>03/06/1997</td>
                            <td>KL897M</td>
                            <td>44 New york, United State</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>John</td>
                            <td>Doe</td>
                            <td>GE334</td>
                            <td>Américaine</td>
                            <td>03/06/1997</td>
                            <td>KL897M</td>
                            <td>44 New york, United State</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require_once('templates/layout.php'); ?>