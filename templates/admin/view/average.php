<?php ob_start(); ?>
    <div class="admin">
        <div class="row">
            <div class="col-md-2 ms-5" id="radioExamType">
                <h4>Types d'examens</h4>
                <?php foreach($exams_types as $item): ?>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" name="exam_type" id="<?= $item ?>" value="<?= $item ?>" <?= ($item == $exam_type) ? 'checked' : '' ?>>
                        <label for="<?= $item ?>" class="form-check-label"><?= $item ?></label>
                    </div>
                <?php endforeach ?>
            </div>
            <div class="col-md-2" id="radioExam">
                <h4>Examens</h4>
            </div>
            <div class="col-md-3" id="radioGroupes">
            </div>
            <div class="col-md-4 ms-3">
                <label for="identifier" class="form-label">Entrer un numéro d'inscription</label>
                <div class="row">
                    <div class="col-auto">
                        <input type="text" name="identifier" id="indentifier" class="form-control">
                    </div>
                    <div class="col-auto">
                        <input type="button" value="Rechercher" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <h2 class="mt-3 text-center">Notes par étudiant</h2>
        <div class="card container">
            <div class="row">
                <div class="col-sm ms-5">
                    <img src="public/images/logo_ipem1.JPG" alt="Logo de IPEM" style="width: 10.5em;" class="ms-3">
                </div>
                <div class="col-md-6">
                    <img src="public/images/logo_accredite.png" alt="Logo accredite" style="margin-left: 65%;">
                </div>
            </div>
            <div class="d-flex flex-column m-auto">
                <div style="background-color: darkgray; border: 1px solid black; padding-left: 140px; padding-right: 140px">
                    <h1 style="font-family: 'Times New Roman', Times, serif;"><strong>RELEVE DE NOTES ET RESULTATS</strong></h1>
                </div>
                <div class="m-auto mt-1" style="border:1px solid black; background-color: darkgray; padding-left: 50px; padding-right: 50px">
                    <h3 style="font-family: 'Times New Roman', Times, serif;"><strong>Session 1</strong></h3>
                </div>
            </div>
            <div class="p-2 ms-5" style="font-size: 1.4em;">
                Matricule: <strong><?= $identifier ?></strong><br>
                Filière: <strong><?= $study ?></strong><br>
                Niveau: <strong><?= ($group == 1) ? '1ère année' : '2ème année' ?></strong><br>
                Année de formation: <strong><?= ((int)$year-1).'/'.$year ?></strong><br>
                Nom et prénom: <strong><?= $full_name ?></strong>
            </div>
           <table style="width: 90%">
                <thead style="border: 2px solid black;">
                    <tr class="table-header bg-gray">
                        <th>Unités de Formation</th>
                        <th class="vertical-text">Coeff.</th>
                        <th class="vertical-text">Note sur 20<br>Controles continues<br><?= ($exam_name == 'CC1') ? 'n°1' : 'n°2' ?></th>
                        <th>Appréciations</th>
                    </tr>
                    <tr>
                        <th colspan="4" style="text-align: center; color:#fff; background-color:lightslategray">Domaines de formation principaux</th>
                    </tr>
                </thead>
                <tbody class="table-body">
                    <?php foreach($averages as $average): ?>
                    <tr>
                        <td><?= $average->name_module ?></td>
                        <td><?= $average->factor ?></td>
                        <td><?= $average->value_average ?></td>
                        <td></td>
                    </tr>
                    <?php endforeach ?>
                    <tr class="bg-gray" style="border: none">
                        <td colspan="2" style="border-bottom: 1px solid black"><strong>Moyenne des notes sur 20</strong></td>
                        <td style="border-bottom: 1px solid black">15</td>
                    </tr>
                </tbody>
           </table>
        </div>
    </div>
    <style>
        .vertical-text {
            writing-mode: vertical-rl;
            transform: rotate(180deg);
        }
        th, td{
            color: #000;
        }
        .bg-gray {
            background-color:darkgrey;
        }
        .table-header th{
            border: 2px solid black;
        }
        .table-body tr{
            border: 1px solid black;
        }
        .table-body td{
            border-right: 2px solid black;
            border-left: 2px solid black;
        }
    </style>
    <script>
        let studies = document.getElementById('study_header');
        let radioGroup = document.getElementById('radioGroupes');
        let radioExamType = document.getElementById('radioExamType');
        let radioExam = document.getElementById('radioExam');
        let radio;
        if (studies.firstChild) {
            setTimeout(() => {
                radio = sendStudyAverage(studies);
            }, 100);
        }
        select_study = (select) => {
            radio = sendStudyAverage(select);
        }
        radioGroup.addEventListener('change', (event) => {
            if (event.target.type == 'radio') {
                radio = event.target.value;
                sendGroupAverage(event.target);
            }
        })
        radioExamType.addEventListener('change', (event) => {
            if (event.target.type = 'radio') {
                sendExamTypeAverage(event.target);
            }
        })
        radioExam.addEventListener('change', (event) => {
            if (event.target.value == 'radio') {
                console.log(event.target.value);
            }
        })
             
        function sendStudyAverage(select) {
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
                    let h4 = document.createElement('h4');
                    h4.textContent = 'Choisissez un groupe';
                    groupes.appendChild(h4);
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
                            result = element;
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
            return group;
        }
        function sendGroupAverage(select) {
            $.ajax({
                type: 'post',
                url: 'ajax',
                data: {
                    'select': 'group',
                    'value': select.value
                }, 
                success: s => {
                    console.log(s);
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
        function sendExamTypeAverage(select) {
            $.ajax({
                type: 'post',
                url: 'ajax',
                data: {
                    'select': 'exam_type',
                    'value': select.value
                },
                success: s => {
                    let parsed = JSON.parse(s);
                    let radioExam = document.getElementById('radioExam');
                    while (radioExam.firstChild) {
                        radioExam.removeChild(radioExam.firstChild);
                    }
                    let h4 = document.createElement('h4');
                    h4.textContent = 'Choisissez un exam';
                    radioExam.appendChild(h4);
                    parsed.forEach(element => {
                        let div = document.createElement('div');
                        div.className = 'form-check';
                        let input = document.createElement('input');
                        input.className = 'form-check-input';
                        input.name = 'exam_name';
                        input.type = 'radio';
                        input.id = element;
                        input.value = element;
                        let label = document.createElement('label');
                        label.setAttribute('for', element);
                        label.className = 'form-check-label';
                        label.textContent = element;
                        div.appendChild(label);
                        div.appendChild(input);
                        radioExam.appendChild(div);
                    });
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
    </script>
<?php 
$insert_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>