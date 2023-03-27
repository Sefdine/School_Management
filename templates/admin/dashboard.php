<?php ob_start(); ?>
<div class="header_dashboard">
    <h2 class="logo_admin">Mon logo</h2>
    <ul class="nav_top">
        <li><a href="home">Home</a></li>
        <li><a href="insert" class="nav_insert">Insert</a></li>
        <li><a href="#" class="nav_update">Update</a></li>
        <li><a href="#" class="nav_delete">Delete</a></li>
    </ul>
    <a href="#" class="year_admin">Year</a>
    <a href="disconnect" class="sign_out">Sign out</a>
</div>
<div class="section_admin">
    <div class="nav_left">
        <ul>
            <li><button onclick="nav_left_button(this)" data-value="student" id="btn_student">Etudiants</button></li>
            <li><button onclick="nav_left_button(this)" data-value="teacher">Enseignants</button></li>
            <li><button onclick="nav_left_button(this)" data-value="study">Filières</button></li>
            <li><button onclick="nav_left_button(this)" data-value="group">Groupes</button></li>
            <li><button onclick="nav_left_button(this)" data-value="level">Niveau</button></li>
            <li><button onclick="nav_left_button(this)" data-value="average">Notes</button></li>
        </ul>
    </div>
    <div class="contain_admin">
        <div class="container">
            <?= $home ?>
            <span class="admin_student"><?= $insert_student ?></span>
            <span class="admin_teacher"><?= $insert_teacher ?></span>
            <span class="admin_study"><?= $insert_study ?></span>
            <span class="admin_group"><?= $insert_group ?></span>
            <span class="admin_level"><?= $insert_level ?></span>
            <span class="admin_average"><?= $insert_average ?></span>              
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require_once('templates/layout.php'); ?>