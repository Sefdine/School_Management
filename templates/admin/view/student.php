<?php ob_start(); ?>

<div class="d-flex flex-row ms-3">
    <div class="ms-5 mt-3 col-md-5">
        <div class="" id="radioGroupes">
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
                <tbody class="view_student_tbody">
                    <?php foreach($list_students as $item): ?>
                    <tr class="view_student_tbody_tr">
                        <td><?= $item->identifier ?></td>
                        <td><?= $item->lastname.' '.$item->firstname ?></td>
                        <td><button class="btn btn-primary">Ouvrir</button></td>
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
                <div class="ms-5 mt-3 part2-info">
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
    if (studies.firstChild) {
        setTimeout(() => {
            sendStudyStudent(studies);
        }, 100);
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