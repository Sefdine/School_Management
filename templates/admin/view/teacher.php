<?php ob_start(); ?>
<div class="d-flex flex-row ms-3">
    <div class="ms-5 mt-3 col-md-5">
        <div id="radioGroupes"></div>
        <div class="mt-4">
            <h2 class="view_teacher_title px-4">Listes des enseignants</h2>
        </div>

        <div class="card mt-3 view_teacher_list">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Plus...</th>
                    </tr>
                </thead>
                <tbody id="view_teacher_tbody">
                    <?php foreach($list_teachers as $item): ?>
                        <tr class="view_teacher_tbody_tr">
                            <td><?= $item->lastname.' '.$item->firstname ?></td>
                            <td><button class="btn btn-primary" value="<?= $item->identifier ?>" onclick="teacher_list_button(this)">Ouvrir</button></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5 ms-5 part-2">
        <div class="card view_teacher_info me-5">
            <h2 class="text-center mt-5">Info complète de l'enseignant</h2>
            <div class="d-flex flex-row mt-3 part2-right">
                <div class="ms-5 mt-3 part2-info" id="teacher_info">
                    <span class="name">Nom <span class="two_point">: </span><?= $info_teachers->lastname.' '.$info_teachers->firstname ?></span><br>
                    <span class="email">Email <span class="two_point">: </span><?= $info_teachers->email ?></span><br>
                    <span class="tel">GSM <span class="two_point">: </span><?= $info_teachers->tel ?></span><br>
                    <span class="cin">CIN <span class="two_point">: </span><?= $info_teachers->cin ?></span><br>
                    <span class="address">Adresse <span class="two_point">: </span><?= $info_teachers->address ?></span><br>
                    <span class="degree">Diplome <span class="two_point">: </span><?= $info_teachers->degree ?></span><br>
                    <span class="experience">Expérience <span class="two_point">: </span><?= ($info_teachers->experience > 1) ? $info_teachers->experience.' ans' : $info_teachers->experience.' an' ?></span><br>
                </div>
                <div class="ms-5 mt-5">
                    <i class="fa-sharp fa-solid fa-person-chalkboard fa-fade"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .identifier_selected {
        background-color:rgba(42, 156, 31, 0.897);;
    }
    .part2-right i {
        font-size: 3.6em;
        margin-top: 50px;
        margin-left: 30px;
    }
    .part2-right {
        font-size: 1.9em;
    }
    .view_teacher_info {
        background-color: darkgray;
        min-height: 70vh;
        color: #fff;
    }
    .part-2 {
        width: 100%;
    }
    .ml-auto {
        margin-left: auto;
    }
    .view_teacher_list {
        background-color:darkgray;
        min-height: 60vh;
    }
    .view_teacher_title {
        background-color: darkblue;
        width: fit-content;
        color: #fff;
        padding: 3px;
    }
</style>
<script>
    let studies = document.getElementById('study_header');
    let radioGroupes = document.getElementById('radioGroupes');
    if (studies.firstChild) {
        setTimeout(() => {
            sendStudyStudent(studies);
        }, 100);
    }
    setTimeout(() => {
        if (radioGroupes.querySelector('input[type="radio"]:checked')) {
            let radio = radioGroupes.querySelector('input[type="radio"]:checked');
            sendGroupTeacher(radio);
        }

    }, 500);
    radioGroupes.addEventListener('change', (event) => {
        if (event.target.type == 'radio') {
            sendGroupTeacher(event.target);
        }
    });
    teacher_list_button = (button) => {
        $.ajax({
            type: 'post',
            url: 'teacherView',
            data: {
                'select': 'button_ouvrir',
                'value': button.value
            },
            success: s => {
                changeTeacherList(s);
                changeTeacherInfo(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    function sendGroupTeacher(select) {
        $.ajax({
            type: 'post',
            url: 'teacherView',
            data: {
                'select': 'group',
                'value': select.value
            },
            success: s => {
                changeTeacherList(s);
                changeTeacherInfo(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    function changeTeacherList(s) {
        let parsed = JSON.parse(s);
        let view_teacher_tbody = document.getElementById('view_teacher_tbody');
        while (view_teacher_tbody.firstChild) {
            view_teacher_tbody.removeChild(view_teacher_tbody.firstChild);
        }
        let list_teachers = parsed.list_teachers;
        let user_id = parsed.user_id;
        list_teachers.forEach(element => {
            let tr = document.createElement('tr');
            tr.className = 'view_teacher_tbody_tr';
            if (user_id == element.identifier) {
                tr.className = 'view_teacher_tbody_tr identifier_selected';
            }
            let name_td = document.createElement('td');
            name_td.textContent = element.lastname+' '+element.firstname;
            let button_td = document.createElement('td');
            let button = document.createElement('button');
            button.className = 'btn btn-primary';
            button.value = element.identifier;
            button.setAttribute('onclick', 'teacher_list_button(this)');
            button.textContent = 'Ouvrir';
            button_td.appendChild(button);
            tr.appendChild(name_td);
            tr.appendChild(button_td);
            view_teacher_tbody.appendChild(tr);
        });

    }
    function changeTeacherInfo(s) {
        let parsed = JSON.parse(s);
        let teacher_info = document.getElementById('teacher_info');
        while (teacher_info.firstChild) {
            teacher_info.removeChild(teacher_info.firstChild);
        }
        let info_teachers = parsed.info_teachers;
        if (info_teachers.firstname) {
            let span_name = document.createElement('span');
            span_name.className = 'name';
            span_name.innerHTML = 'Nom <span class="two_point">:</span> '+info_teachers.lastname+' '+info_teachers.firstname+'<br>';
            let email_span = document.createElement('span');
            email_span.className = 'email';
            email_span.innerHTML = 'Email <span class="two_point">:</span> '+info_teachers.email+'<br>';
            let tel_span = document.createElement('span');
            tel_span.className = 'tel';
            tel_span.innerHTML = 'GSM <span class="two_point">:</span> '+info_teachers.tel+'<br>';
            let cin_span = document.createElement('span');
            cin_span.className = 'cin';
            cin_span.innerHTML = 'CIN <span class="two_point">:</span> '+info_teachers.cin+'<br>';
            let address_span = document.createElement('span');
            address_span.className = 'address';
            address_span.innerHTML = 'Adresse <span class="two_point">:</span> '+info_teachers.address+'<br>';
            let degree_span = document.createElement('span');
            degree_span.className = 'degree';
            degree_span.innerHTML = 'Diplome <span class="two_point">:</span> '+info_teachers.degree+'<br>';
            let experience_span = document.createElement('span');
            experience_span.className = 'experience';
            experience_span.innerHTML = 'Expérience <span class="two_point">:</span> '+((info_teachers.experience > 1) ? info_teachers.experience+' ans' : info_teachers.experience+' an')+'<br>';
            teacher_info.appendChild(span_name); 
            teacher_info.appendChild(email_span); 
            teacher_info.appendChild(tel_span); 
            teacher_info.appendChild(email_span); 
            teacher_info.appendChild(cin_span); 
            teacher_info.appendChild(address_span); 
            teacher_info.appendChild(degree_span); 
            teacher_info.appendChild(experience_span); 
        }
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
$insert_teacher = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>