<?php ob_start(); ?>
<div class="mt-3 d-flex mx-5">
    <div class="ms-3 dashboard_icon">
        <i class="fa-solid fa-gauge"></i>
        <label class="dashboard_text ms-1">Dashboard</label>
    </div>
    <h2 class="ml-auto home_title">Institut Parcours et Métiers</h2>
    <div class="groupe_select d-flex ml-auto">
        <label for="groupes" class="form-label me-2">Groupes</label>
        <select name="groupes" id="groupes" class="form-select">
            <option value="1">1ère année</option>
            <option value="2">2ème année</option>
        </select>
    </div>
</div>
<div class="card p-3 container d-flex flex-row plan_number">
    <div class="individual">
        <label class="m-1">Par groupe</label>
        <div class="mt-2 d-flex ">
            <div class="ms-2 d-flex registrer_data py-3 same_size">
                <div class="registrer_data_text ms-3">
                    <p id="registrer_data_value"><?= $registrer_data ?></p>
                    <label>Inscrits</label>
                </div>
                <i class="fa-solid fa-user-graduate"></i>
            </div>
            <div class="ms-2 d-flex deleted_data py-3 same_size">
                <div class="deleted_data_text ms-3">
                    <p id="deleted_data_value"><?= $deleted_data ?></p>
                    <label>Abandons</label>
                </div>
                <i class="fa-solid fa-user-minus"></i>
            </div>
        </div>
    </div>
    <div class="total">
        <label class="m-1">Total</label>
        <div class="mt-2 d-flex">
            <div class="ms-2 d-flex registrer_all py-3 same_size">
                <div class="registrer_all_text ms-3">
                    <p id="registrer_all_value"><?= $registrer_all ?></p>
                    <label>Inscrits</label>
                </div>
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="ms-2 d-flex deleted_all py-3 same_size">
                <div class="deleted_all_text ms-3">
                    <p id="deleted_all_value"><?= $deleted_all ?></p>
                    <label>Abandons</label>
                </div>
                <i class="fa-solid fa-users-slash"></i>
            </div>
        </div>
    </div>
</div>
<div class="card m-2 home_data">
    <div class="d-flex home_data_first">
        <h4 class="mt-2 ms-3 home_data_title">Listes des étudiant</h4>
        <div class="mt-2 me-5 ml-auto">
            <button class="btn">
                <label>Imprimer</label>
                <i class="fa-solid fa-print"></i>
            </button>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr id="home_thead_tr">
            </tr>
            <tbody id="home_tbody">
            </tbody>
        </thead>
    </table>
</div>
<style>
    #home_thead_tr td {
        font-weight: bold;
    }
    .home_data_first {
        background-color: darkgrey;
    }
    .home_data_title {
        padding: 5px;
        color: #fff;
    }
    .home_data {
        min-height: 70vh;
        background-color: rgb(119, 119, 161);
    }
    .home_title {
        font-weight: bolder;
    }
    .groupe_select {
        background-color:rgb(167, 73, 10);
        padding: 10px;
    }
    .groupe_select label {
        color: #fff;
    }
    .dashboard_text {
        text-decoration: underline;
    }
    .dashboard_icon i{
        color: #000;
    }
    .total {
        background-color:darkkhaki;
    }
    .individual {
        background-color:darkcyan;
    }
    .individual, .total {
        width: max-content;
        padding: 4px;
    }
    .plan_number i {
        font-size: 3.8em;
        margin-left: 40%;
        margin-top: 30px;
    }
    .same_size {
        color: #fff;
        width: 310px;
    }
    .registrer_data {
        background-color: rgb(31, 31, 136);
    }
    .same_size p{
        font-size: 2.4em;
        font-weight: bolder;
    }
    .ml-auto {
        margin-left: auto;
    }
    .deleted_data {
        background-color: rgb(129, 11, 27);
    }
    .registrer_all {
        background-color: rgb(36, 100, 20);
    }
    .deleted_all {
        background-color: rgb(114, 82, 39);
    }
</style>
<script>
    let groupes = document.getElementById('groupes');
    let session_nav_left = '<?= $_SESSION['nav_left'] ?>';
    groupes.addEventListener('change', (event) => {
        sendGroupHome(event.target);
    });
    if (groupes.firstChild) {
        setTimeout(() => {
            sendGroupHome(groupes);
        }, 100);
    }
    function sendGroupHome(select) {
        $.ajax({
            type: 'post',
            url: 'homeAdmin',
            data: {
                'select': 'group',
                'value': select.value
            },
            success: s => {
                changeValueRegistrerDeleted(s);
                if (session_nav_left == 'student') {
                    displayTableStudent(s);
                } else if (session_nav_left == 'teacher') {
                    displayTableTeacher(s);
                } else if(session_nav_left == 'average') {
                    displayTableAverage(s);
                } else {
                    displayTableTeacher(s);
                }
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function changeValueRegistrerDeleted(s) {
        let parsed = JSON.parse(s);
        let registrer_data = parsed.registrer_data;
        let deleted_data = parsed.deleted_data;
        
        // Html paragraph
        let registrer_data_value = document.getElementById('registrer_data_value');
        let deleted_data_value = document.getElementById('deleted_data_value');
        registrer_data_value.textContent = registrer_data;
        deleted_data_value.textContent = deleted_data;
    }
    function displayTableAverage(s) {
        let parsed = JSON.parse(s);
        let home_thead_tr = document.getElementById('home_thead_tr');
        while (home_thead_tr.firstChild) {
            home_thead_tr.removeChild(home_thead_tr.firstChild);
        }
        let td_name = document.createElement('td');
        td_name.textContent = 'Nom';
        home_thead_tr.appendChild(td_name);

        let modules = parsed.modules;
        modules.forEach(element => {
            let td_module = document.createElement('td');
            td_module.textContent = element;
            home_thead_tr.appendChild(td_module);
        });

        let students = parsed.students;
        let home_tbody = document.getElementById('home_tbody');
        while (home_tbody.firstChild) {
            home_tbody.removeChild(home_tbody.firstChild);
        }
        students.forEach(element => {
            let tr = document.createElement('tr');
            let name_td = document.createElement('td');
            name_td.textContent = element.name;
            tr.appendChild(name_td);
            home_tbody.appendChild(tr);
        })
    }
    function displayTableTeacher(s) {
        let parsed = JSON.parse(s);
        let home_thead_tr = document.getElementById('home_thead_tr');
        while (home_thead_tr.firstChild) {
            home_thead_tr.removeChild(home_thead_tr.firstChild);
        }
        let td_name = document.createElement('td');
        td_name.textContent = 'Nom';
        let td_tel = document.createElement('td');
        td_tel.textContent = 'GSM';
        let td_email = document.createElement('td');
        td_email.textContent = 'Email';
        let td_cin = document.createElement('td');
        td_cin.textContent = 'CIN';
        let td_degree = document.createElement('td');
        td_degree.textContent = 'Diplome';
        let td_experience = document.createElement('td');
        td_experience.textContent = 'Expérience';
        home_thead_tr.appendChild(td_name);
        home_thead_tr.appendChild(td_tel);
        home_thead_tr.appendChild(td_email);
        home_thead_tr.appendChild(td_cin);
        home_thead_tr.appendChild(td_degree);
        home_thead_tr.appendChild(td_experience);

        let teachers = parsed.teachers;
        let home_tbody = document.getElementById('home_tbody');
        while (home_tbody.firstChild) {
            home_tbody.removeChild(home_tbody.firstChild);
        }
        teachers.forEach(element => {
            let tr = document.createElement('tr');
            let name_td = document.createElement('td');
            name_td.textContent = element.name;
            let tel_td = document.createElement('td');
            tel_td.textContent = element.tel;
            let email_td = document.createElement('td');
            email_td.textContent = element.email;
            let cin_td = document.createElement('td');
            cin_td.textContent = element.cin;
            let degree_td = document.createElement('td');
            degree_td.textContent = element.degree;
            let experience_td = document.createElement('td');
            experience_td.textContent = element.experience;

            tr.appendChild(name_td);
            tr.appendChild(tel_td);
            tr.appendChild(email_td);
            tr.appendChild(cin_td);
            tr.appendChild(degree_td);
            tr.appendChild(experience_td);
            home_tbody.appendChild(tr);
        });
    }
    function displayTableStudent(s) {
        let parsed = JSON.parse(s);
        let home_thead_tr = document.getElementById('home_thead_tr');
        while (home_thead_tr.firstChild) {
            home_thead_tr.removeChild(home_thead_tr.firstChild);
        }
        let td_matricule = document.createElement('td');
        td_matricule.textContent = 'Matricule';
        let td_name = document.createElement('td');
        td_name.textContent = 'Nom';
        let td_nationality = document.createElement('td');
        td_nationality.textContent = 'Nationalité';
        let td_birthday = document.createElement('td');
        td_birthday.textContent = 'Date de naissance';
        let td_place_birth = document.createElement('td');
        td_place_birth.textContent = 'Lieu de naissance';
        let td_cin = document.createElement('td');
        td_cin.textContent = 'CIN';
        let td_entry_date = document.createElement('td');
        td_entry_date.textContent = 'Date d\'entrée au Maroc';
        let td_level_study = document.createElement('td');
        td_level_study.textContent = 'Diplome';

        home_thead_tr.appendChild(td_matricule);
        home_thead_tr.appendChild(td_name);
        home_thead_tr.appendChild(td_nationality);
        home_thead_tr.appendChild(td_birthday);
        home_thead_tr.appendChild(td_place_birth);
        home_thead_tr.appendChild(td_cin);
        home_thead_tr.appendChild(td_entry_date);
        home_thead_tr.appendChild(td_level_study);

        let students = parsed.students;
        let home_tbody = document.getElementById('home_tbody');
        while (home_tbody.firstChild) {
            home_tbody.removeChild(home_tbody.firstChild);
        }
        students.forEach(element => {
            let tr = document.createElement('tr');
            let matricule_td = document.createElement('td');
            matricule_td.textContent = element.identifier;
            let name_td = document.createElement('td');
            name_td.textContent = element.name;
            let nationality_td = document.createElement('td');
            nationality_td.textContent = element.nationality;
            let birthday_td = document.createElement('td');
            birthday_td.textContent = element.date_of_birth;
            let place_birth_td = document.createElement('td');
            place_birth_td.textContent = element.place_birth;
            let cin_td = document.createElement('td');
            cin_td.textContent = element.cin;
            let entry_date_td = document.createElement('td');
            entry_date_td.textContent = element.entry_date;
            let level_study_td = document.createElement('td');
            level_study_td.textContent = element.level_study;

            tr.appendChild(matricule_td);
            tr.appendChild(name_td);
            tr.appendChild(nationality_td);
            tr.appendChild(birthday_td);
            tr.appendChild(place_birth_td);
            tr.appendChild(cin_td);
            tr.appendChild(entry_date_td);
            tr.appendChild(level_study_td);
            home_tbody.appendChild(tr);
        });
    }
</script>
<?php 
$home = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>