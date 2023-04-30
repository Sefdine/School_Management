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
<script>
    let year = document.getElementById('year');
    let session_average = sessionStorage.getItem('average');
    if (session_average != 1 || session_average == undefined) {
        $('#individual_insert').hide();
    }
    if (year.value) {
        sendYear(year);
    }
    select_year = (select) => {
        sendYear(select);
    }
    nav_top_a = (a) => {
        let nav_top = a.getAttribute('data-value');
        sendValueSession({'nav_top': nav_top}, document.location = 'displayDashboard');
    }
    nav_left_button = (button) => {
        let nav_left = button.getAttribute('data-value');
        sendValueSession(
            {'nav_left': nav_left, 'year': year.value},
            document.location = 'displayDashboard'
        );
        if (nav_left == 'average') {
            sessionStorage.setItem('average', 1);
        } else {
            sessionStorage.setItem('average', 0);
        }
    }

    function sendYear(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'year',
                'value': select.value
            },
            dataType: 'json',
            success: s => {
                let studies = document.getElementById('study_header');
                let study = "<?= $study ?>";
                while (studies.firstChild) {
                    studies.removeChild(studies.firstChild);
                }
                s.forEach(element => {
                    let option = document.createElement('option');
                    option.value = element;
                    option.className ='text-center';
                    option.textContent = element;
                    if (element == study) {
                        option.setAttribute('selected', 'selected')
                    }
                    studies.appendChild(option);
                });
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function sendValueSession(data, action) {
        $.ajax({
            type: 'POST',
            url: 'displayDashboard',
            data: data,
            success: s => {
                action;
            },
            error: (error) => {
                console.error(error);
            }
        });
    }
</script>
<?php $content = ob_get_clean(); ?>
<?php require_once('templates/layout.php'); ?>