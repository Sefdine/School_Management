
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
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require_once('templates/layout.php'); ?>