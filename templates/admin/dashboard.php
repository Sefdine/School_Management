<?php ob_start(); ?>
<div class="header_dashboard">
    <h2 class="logo_admin">Mon logo</h2>
    <ul class="nav_top">
        <li><a href="home">Accueil</a></li>
        <li><a href="displayDashboard" class="nav_insert" onclick="nav_top_a(this)" data-value="insert">Inscription</a></li>
        <li><a href="displayDashboard" class="nav_update" onclick="nav_top_a(this)" data-value="update">Etat</a></li>
        <li><a href="displayDashboard" class="nav_delete" onclick="nav_top_a(this)" data-value="delete">Suppression</a></li>
    </ul>
    <select name="study" id="study_header" onchange="select_study(this)">
        <option value="title" disabled selected class="text-center">Filières</option>
        <?php foreach($studies as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $study) ? 'selected' : '' ?> class="text-center"><?= $item ?></option>
        <?php endforeach ?>
    </select>
    <select id="year" onchange="select_year(this)">
        <?php foreach($years as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $year) ? 'selected' : '' ?>><?= $item ?></option>
        <?php endforeach ?>
    </select>
    <a href="disconnect" class="sign_out">Sign out</a>
</div>
<div class="section_admin">
    <div class="nav_left">
        <ul>
            <li><button onclick="nav_left_button(this)" data-value="teacher">Enseignants</button></li>
            <li><button onclick="nav_left_button(this)" data-value="student" id="btn_student">Etudiants</button></li>
            <li><button onclick="nav_left_button(this)" data-value="average">Notes</button></li>
            <br>
            <a href="<?= URL_ROOT ?>landing" id="individual_insert">Note Individuelle</a>
        </ul>
    </div>
    <div class="contain_admin">
        <div class="container">
            <?php include_once('templates/errors/errors.php') ?>
            <?= (isset($home)) ? $home : '' ?>
            <span class="admin_student"><?= (isset($insert_student)) ? $insert_student : ''?></span>
            <span class="admin_teacher"><?= (isset($insert_teacher)) ? $insert_teacher : '' ?></span>
            <span class="admin_average"><?= (isset($insert_average)) ? $insert_average : '' ?></span>              
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require_once('templates/layout.php'); ?>