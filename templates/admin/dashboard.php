<?php ob_start(); ?>
<div class="header_dashboard">
    <a href="home" class="logo_admin"><h2><strong><span style="color: rgb(167, 73, 10);">I</span><span style="color: rgb(36, 19, 138);">PEM</span></strong></h2></a>
    <ul class="nav_top">
        <li><a href="home">Accueil <i class="fa-solid fa-house"></i></a></li>
        <li><a href="displayDashboard" class="nav_insert" onclick="nav_top_a(this)" data-value="insert">Inscription <i class="fa-solid fa-keyboard"></i></a></li>
        <li><a href="displayDashboard" class="nav_update" onclick="nav_top_a(this)" data-value="view">Etat <i class="fa-solid fa-display"></i></a></li>
    </ul>
    <select name="study" id="study_header" onchange="select_study(this)">
        <option value="title" disabled selected class="text-center">Filières</option>
        <?php foreach($studies as $item): ?>
            <option value="<?= $item ?>" <?= ($item == $_SESSION['insert_study']) ? 'selected' : '' ?> class="text-center"><?= $item ?></option>
        <?php endforeach ?>
    </select>
    <select id="year" onchange="select_year(this)">
        <?php foreach($years as $item): ?>
            <option value="<?= $item ?>" <?= (($item == $year) ? 'selected' : '') ?>><?= $item ?></option>
        <?php endforeach ?>
    </select>
    <a href="disconnect" class="sign_out">Sign out</a>
</div>
<div class="section_admin">
    <div class="nav_left">
        <ul>
            <li class="<?= (($_SESSION['nav_left'] == 'teacher') || !isset($_SESSION['nav_left'])) ? 'nav_left_checked' : '' ?>"><button onclick="nav_left_button(this)" data-value="teacher">Enseignants <i class="fa-solid fa-user-tie"></i></button></li>
            <li class="<?= ($_SESSION['nav_left'] == 'student') ? 'nav_left_checked' : '' ?>"><button onclick="nav_left_button(this)" data-value="student" id="btn_student">Etudiants <i class="fa-solid fa-user-graduate"></i></button></li>
            <li class="<?= ($_SESSION['nav_left'] == 'average') ? 'nav_left_checked' : '' ?>"><button onclick="nav_left_button(this)" data-value="average">Notes <i class="fa-solid fa-marker"></i></button></li>
            <br>
            <a href="<?= URL_ROOT ?>landing" id="individual_insert">Note Individuelle</a>
        </ul>
    </div>
    <div class="contain_admin">
        <?php include_once('templates/errors/errors.php') ?>
        <?= (isset($home)) ? $home : '' ?>
        <span class="admin_student"><?= (isset($insert_student)) ? $insert_student : ''?></span>
        <span class="admin_teacher"><?= (isset($insert_teacher)) ? $insert_teacher : '' ?></span>
        <span class="admin_average"><?= (isset($insert_average)) ? $insert_average : '' ?></span>              
    </div>
</div>
<script>
    let year = document.getElementById('year');
    let study = document.getElementById('study_header');
    let session_average = sessionStorage.getItem('average');
    let session_nav_insert = '<?= $_SESSION['nav_top'] ?>'
    if (session_average != 1 || session_average == undefined) {
        $('#individual_insert').hide();
    }
    if (year.value) {
        sendYear(year);
    }
    if (study.value) {
        setTimeout(() => {
            sendStudyDashboard(study);
        }, 100);
    }
    select_year = (select) => {
        sendYear(select);
        if (session_nav_insert == 'home') {
            document.location = 'home';
        } else {
            document.location = 'displayDashboard';
        }
    }
    select_study = (select) => {
        sendStudyDashboard(select);
        if (session_nav_insert == 'home') {
            document.location = 'home';
        } else {
            document.location = 'displayDashboard';
        }
    }
    nav_top_a = (a) => {
        let nav_top = a.getAttribute('data-value');
        sendValueSession({'nav_top': nav_top}, document.location = 'displayDashboard');
    }
    nav_left_button = (button) => {
        let nav_left = button.getAttribute('data-value');
        let location;

        if (session_nav_insert == 'home') {
            location = 'home';
        } else {
            location = 'displayDashboard';
        }
        sendValueSession(
            {'nav_left': nav_left, 'year': year.value},
            document.location = location
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
    function sendStudyDashboard(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'study',
                'value': select.value
            },
            success: s => {
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
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