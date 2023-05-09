<?php ob_start(); ?>

<div class="d-flex flex-row ms-3">
    <div class="ms-5 mt-3 col-md-5">
        <div id="radioGroupes">
        </div>
        <div class="mt-4">
            <h2 class="view_student_title px-4">Listes des inscrits</h1>
        </div>
        <div class="card mt-3 view_student_list">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom</th>
                        <th>Plus...</th>
                    </tr>
                </thead>
                <tbody id="view_student_tbody">
                    <?php foreach($list_students as $item): ?>
                    <tr class="view_student_tbody_tr <?= ($current_identifier_view_student == $item->identifier) ? 'identifier_selected' : ''  ?>">
                        <td><?= $item->identifier ?></td>
                        <td><?= $item->lastname.' '.$item->firstname ?></td>
                        <td><button class="btn btn-primary" onclick="student_list_button(this)" value="<?= $item->identifier ?>">Ouvrir</button></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between my-2 mx-5" id="btn_next_previous">
            <?php if ($page_view_average >= 1): ?>
                <button class="btn btn-primary" onclick="previous_btn_view_average()">&laquo; Précédant</button>
            <?php endif ?>
            <?php if ($page_view_average < $pages_view_averages): ?>
                <button class="btn btn-primary ml-auto" onclick="next_btn_view_average()">Suivant &raquo;</button>
            <?php endif ?>
        </div>
    </div>
    <div class="mt-5 ms-5 part-2">
        <div class="card view_student_info me-5">
            <h2 class="text-center mt-5">Info complète de l'étudiant</h2>
            <div class="d-flex flex-row mt-3 part2-right">
                <div class="ms-5 mt-3 part2-info" id="student_info">
                    <span class="name">Nom <span class="two_point">:</span> <?= $info_student->lastname.' '.$info_student->firstname ?></span><br>
                    <span class="identifier">Matricule <span class="two_point">:</span> <?= $info_student->identifier ?></span><br>
                    <span class="birthday">Date de Naissance<span class="two_point">:</span> <?= $info_student->birthday ?></span><br>
                    <span class="place_of_birth">Lieu de naissance <span class="two_point">:</span> <?= $info_student->place_birth ?></span><br>
                    <span class="registration_date">Date d'inscription <span class="two_point">:</span> <?= $info_student->registration_date ?></span><br>
                    <span class="nationality">Nationalité <span class="two_point">:</span> <?= $info_student->nationality ?></span><br>
                    <span class="cin">CIN <span class="two_point">:</span> <?= $info_student->cin ?></span><br>
                    <span class="gender">Genre <span class="two_point">:</span> <?= $info_student->gender ?></span><br>
                    <span class="address">Adresse <span class="two_point">:</span> <?= $info_student->address ?></span><br>
                    <span class="level">Niveau <span class="two_point">:</span> <?= $info_student->level_study ?></span><br>
                    <span class="entry_date">Date d'entrée au Maroc <span class="two_point">:</span> <?= $info_student->entry_date ?></span><br>
                </div>
                <div class="ms-5 mt-5">
                    <i class="fa-solid fa-graduation-cap fa-fade" style="color: #dcdcef;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .identifier_selected {
        background-color:aqua;
    }
    .part2-right i {
        font-size: 3.6em;
        margin-top: 50px;
        margin-left: 30px;
    }
    .part2-info .name .two_point {
        margin-left: 163px;
    }
    .part2-info .identifier .two_point {
        margin-left: 123px;
    }
    .part2-info .birthday .two_point {
        margin-left: 52px;
    }
    .part2-info .place_of_birth .two_point {
        margin-left: 56px;
    }
    .part2-info .registration_date .two_point {
        margin-left: 55px;
    }
    .part2-info .nationality .two_point {
        margin-left: 111px;
    }
    .part2-info .cin .two_point {
        margin-left: 177px;
    }
    .part2-info .gender .two_point {
        margin-left: 156px;
    }
    .part2-info .address .two_point {
        margin-left: 139px;
    }
    .part2-info .level .two_point {
        margin-left: 149px;
    }
    .part2-info .entry_date .two_point {
        margin-left: 4px;
    }
    .part2-right {
        font-size: 1.2em;
    }

    .view_student_info {
        background-color:darkslategray;
        min-height: 70vh;
        color: #fff;
    }
    .part-2 {
        width: 100%;
    }
    .view_student_tbody_tr td {
        color: #fff!important;
    }
    .view_student_list {
        background-color:darkcyan;
        min-height: 70vh;
    }
    .view_student_title {
        background-color: darkgrey;
        border-radius: 15px;
        width: fit-content;
        color: #fff;
    }
    .ml-auto {
        margin-left: auto;
    }
</style>

<script>
    let studies = document.getElementById('study_header');
    let radioGroupes = document.getElementById('radioGroupes');
    
    previous_btn_view_average = (button) => {
        sendNextPrevious('previous');
    }
    next_btn_view_average = (button) => {
        sendNextPrevious('next');
    }
    if (studies.firstChild) {
        setTimeout(() => {
            sendStudyStudent(studies);
        }, 100);
    }
    setTimeout(() => {
        if (radioGroupes.querySelector('input[type="radio"]:checked')) {
            let radio = radioGroupes.querySelector('input[type="radio"]:checked');
            sendGroupView(radio);
        }

    }, 500);
    radioGroupes.addEventListener('change', (event) => {
        if (event.target.type == 'radio') {
            sendGroupView(event.target);
        }
    })
    student_list_button = (button) => {
        $.ajax({
            type: 'post',
            url: 'studentView',
            data: {
                'select': 'button_ouvrir',
                'value': button.value
            },
            success: s => {
                changeStudentList(s);
                changeStudentInfo(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    function sendNextPrevious(button) {
        $.ajax({
            type: 'post',
            url: 'studentView',
            data: {
                'select': button,
                'value': 1
            },
            success: s => {
                changeStudentList(s);
                changeStudentInfo(s);
                displayButtonNextPrevious(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    function displayButtonNextPrevious(s) {
        let parsed = JSON.parse(s);
        let page_view_average = parsed.page_view_average;
        let pages_view_averages = parsed.pages_view_averages;
        let btn_next_previous = document.getElementById('btn_next_previous');
        while (btn_next_previous.firstChild) {
            btn_next_previous.removeChild(btn_next_previous.firstChild);
        }
        if (page_view_average >= 1) {
            let previous = document.createElement('button');
            previous.setAttribute('onclick', 'previous_btn_view_average()');
            previous.textContent = 'Précédant';
            previous.className = 'btn btn-primary';
            btn_next_previous.appendChild(previous);
        }
        if (page_view_average < pages_view_averages) {
            let next = document.createElement('button');
            next.className = 'btn btn-primary ml-auto';
            next.setAttribute('onclick', 'next_btn_view_average()');
            next.textContent = 'Suivant';
            btn_next_previous.appendChild(next);
        }
    }
    function sendGroupView(select) {
        $.ajax({
            type: 'post',
            url: 'studentView',
            data: {
                'select': 'group',
                'value': select.value
            },
            success: s => {
                changeStudentList(s);
                changeStudentInfo(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function changeStudentInfo(s) {
        let parsed = JSON.parse(s);
        let student_info = document.getElementById('student_info');
        while(student_info.firstChild) {
            student_info.removeChild(student_info.firstChild);
        }
        let info_student = parsed.info_student;
        if (info_student.firstname) { 
            info_student.registration_date = (!info_student.registration_date) ? '' : info_student.registration_date;
            info_student.firstname = (!info_student.firstname) ? '' : info_student.firstname;
            info_student.lastname = (!info_student.lastname) ? '' : info_student.lastname;
            info_student.date_of_birth = (!info_student.date_of_birth) ? '' : info_student.date_of_birth;
            info_student.place_birth = (!info_student.place_birth) ? '' : info_student.place_birth;
            info_student.nationality = (!info_student.nationality) ? '' : info_student.nationality;
            info_student.cin = (!info_student.cin) ? '' : info_student.cin;
            info_student.gender = (!info_student.gender) ? '' : info_student.gender;
            info_student.address = (!info_student.address) ? '' : info_student.address;
            info_student.level_study = (!info_student.level_study) ? '' : info_student.level_study;
            info_student.entry_date = (!info_student.entry_date) ? '' : info_student.entry_date;
            let span_name = document.createElement('span');
            span_name.className = 'name';
            span_name.innerHTML = "Nom <span class='two_point'>:</span> "+info_student.lastname+' '+info_student.firstname+"</span><br>";
            let span_identifier = document.createElement('span');
            span_identifier.className = 'identifier';
            span_identifier.innerHTML = 'Matricule <span class="two_point">:</span> '+info_student.identifier+"</span><br>";
            let span_birthday = document.createElement('span');
            span_birthday.className = 'birthday';
            span_birthday.innerHTML = "Date de naissance <span class='two_point'>:</span> "+info_student.date_of_birth+"</span><br>";
            let span_place_of_birth = document.createElement('span');
            span_place_of_birth.className = 'place_of_birth';
            span_place_of_birth.innerHTML = 'Lieu de naissance <span class="two_point">:</span> '+info_student.place_birth+'</span><br>';
            let span_registration_date = document.createElement('span');
            span_registration_date.className = 'registration_date';
            span_registration_date.innerHTML = 'Date d\'inscription <span class="two_point">:</span> '+info_student.registration_date+'</span><br>';
            let span_nationality = document.createElement('span');
            span_nationality.className = 'nationality';
            span_nationality.innerHTML = 'Nationalité <span class="two_point">:</span> '+info_student.nationality+'<br>';
            let span_cin = document.createElement('span');
            span_cin.className = 'cin';
            span_cin.innerHTML = 'CIN <span class="two_point">:</span> '+info_student.cin+'<br>';
            let span_gender = document.createElement('span');
            span_gender.className = 'gender';
            if (!info_student.gender) {
                info_student.gender = '';
            } else if (info_student.gender == 'M' || info_student.gender == 'male') {
                info_student.gender = 'Homme';
            } else if (info_student.gender == 'F' || info_student.gender == 'female') {
                info_student.gender = 'Femme';
            }
            span_gender.innerHTML = 'Genre <span class="two_point">:</span> '+info_student.gender+'<br>';
            let span_address = document.createElement('span');
            span_address.className = 'address';
            span_address.innerHTML = 'Adresse <span class="two_point">:</span> '+info_student.address+'<br>';
            let span_level = document.createElement('span');
            span_level.className = 'level';
            span_level.innerHTML = 'Niveau <span class="two_point">:</span> '+info_student.level_study+'<br>';
            let span_entry_date = document.createElement('span');
            span_entry_date.className = 'entry_date';
            span_entry_date.innerHTML = 'Date d\'entrée au Maroc <span class="two_point">:</span> '+info_student.entry_date+'<br>';
            student_info.appendChild(span_name);
            student_info.appendChild(span_identifier);
            student_info.appendChild(span_birthday);
            student_info.appendChild(span_place_of_birth);
            student_info.appendChild(span_registration_date);
            student_info.appendChild(span_nationality);
            student_info.appendChild(span_cin);
            student_info.appendChild(span_gender);
            student_info.appendChild(span_address);
            student_info.appendChild(span_level);
            student_info.appendChild(span_entry_date);
        }
    }
    function changeStudentList(s) {
        let parsed = JSON.parse(s);
        let view_student_tbody = document.getElementById('view_student_tbody');
        while (view_student_tbody.firstChild) {
            view_student_tbody.removeChild(view_student_tbody.firstChild);
        }
        let list_students = parsed.list_students;
        let current_identifier_view_student = parsed.current_identifier_view_student;
        list_students.forEach(element => {
            let tr = document.createElement('tr');
            tr.className = 'view_student_tbody_tr';
            if (current_identifier_view_student == element.identifier) {
                tr.className = 'view_student_tbody_tr identifier_selected';
            }
            let td_identifier = document.createElement('td');
            td_identifier.textContent = element.identifier;
            let td_name = document.createElement('td');
            element.lastname = (!element.lastname) ? '' : element.lastname;
            element.firstname = (!element.firstname) ? '' : element.firstname;
            td_name.textContent = element.lastname+' '+element.firstname;
            let td_button = document.createElement('td');
            let button = document.createElement('button');
            button.textContent = 'Ouvrir';
            button.className = 'btn btn-primary';
            button.setAttribute('onclick', "student_list_button(this)");
            button.value = element.identifier;
            td_button.appendChild(button);
            tr.appendChild(td_identifier);
            tr.appendChild(td_name);
            tr.appendChild(td_button);
            view_student_tbody.appendChild(tr);
        });
    }
    function sendStudyStudent(select) {
        let group = "<?= $group ?>";
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'study',
                'value': select.value
            },
            success: s => {
                let parsed = JSON.parse(s);
                let groupes = document.getElementById('radioGroupes');
                while (groupes.firstChild) {
                    groupes.removeChild(groupes.firstChild);
                }
                let h3 = document.createElement('h3');
                h3.textContent = 'Choisissez un groupe';
                groupes.appendChild(h3);
                parsed.forEach(element => {
                    let div = document.createElement('div');
                    div.className = 'form-check';
                    let input = document.createElement('input');
                    input.name = 'groupRadio';
                    input.type = 'radio';
                    input.value = element;
                    input.className = 'form-check-input';
                    input.setAttribute('id', 'year'+element);
                    if (group == element) {
                        input.setAttribute('checked', 'checked');
                    }
                    let label = document.createElement('label');
                    label.className = 'form-check-label';
                    label.setAttribute('for', 'year'+element);
                    label.textContent = (element == 1) ? '1ère année' : '2ème année';
                    div.appendChild(input);
                    div.appendChild(label);
                    groupes.appendChild(div);
                });
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
</script>

<?php 
$insert_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>