<?php ob_start(); ?>
    <div class="admin">
        <div id="error" style="width: fit-content;"></div>
        <div class="row m-auto">
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
                        <input type="text" name="identifier" id="indentifier_view_average" class="form-control">
                    </div>
                    <div class="col-auto">
                        <input type="button" value="Rechercher" onclick="SearchIdentifierViewAverage()" class="btn btn-primary">
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr>
        <div class="row mt-3 m-auto">
            <div class="col-md-4 ms-5">
                <h2 class="ms-5">Notes par étudiant</h2>
            </div>
            <div class="col-md-2" style="margin-left: 75%;">
                <button onclick="relevePrint()" class="btn fs-4">Imprimer <i class="fa-solid fa-print"></i></button>
            </div>
        </div>
        <div class="card container" id="releve" style="padding-bottom: 30px;">
            <div class="d-flex justify-content-between mt-1" style="width: 100%;">
                <div class="image_logo_width">
                    <img src="public/images/logo_ipem1.JPG" alt="Logo de IPEM" style="width: 90px" class="ms-2">
                </div>
                <div class="image_logo_width ml-auto">
                    <img src="public/images/logo_accredite.png" class="position-absolute end-0 me-2" alt="Logo accredite" style="width: 100px;">
                </div>
            </div>
            <div class="d-flex flex-column ms-auto me-auto">
                <div class="releve_title" id="releve_title">
                    <h1><strong>RELEVE DE NOTES ET RESULTATS</strong></h1>
                </div>
                <div class="m-auto mt-1" style="border:1px solid black; background-color: darkgray; padding-left: 50px; padding-right: 50px">
                    <h3 style="font-family: 'Times New Roman', Times, serif; font-size: medium"><strong>Session 1</strong></h3>
                </div>
            </div>
            <div class="p-2 ms-5" id="student_info">
                Matricule: <strong><?= $identifier ?></strong><br>
                Filière: <strong><?= $study ?></strong><br>
                Niveau: <strong><?= ($group == 1) ? '1ère année' : '2ème année' ?></strong><br>
                Année de formation: <strong><?= ((int)$year-1).'/'.$year ?></strong><br>
                Nom et prénom: <strong><?= $full_name ?></strong>
            </div>
           <table style="width: 90%; height: fit-contain" id="releveTable">
                <thead id="thead_view_average">
                    <tr class="table-header bg-gray">
                        <th>Unités de Formation</th>
                        <th>Coeff.</th>
                        <th id="exam_name_average_view"><?= $exam_name ?></th>
                        <th>Appréciations</th>
                    </tr>
                    <tr>
                        <th colspan="4" class="thead_tr_colspan border_complet">Domaines de formation principaux</th>
                    </tr>
                </thead>
                <tbody class="table-body" id="tbody_average_view">
                       
                </tbody>
           </table>
           <div class="d-flex justify-content-between ms-5">
            <div class=""> 
                Fait à Casablanca, <br>Le <?= ' '. date('d/m/Y') ?>
            </div>
            <div class="me-5">
                Signature du directeur de l'établissement
            </div>
           </div>
        </div>
        <div class="d-flex justify-content-between my-2 mx-5" id="btn_next_previous">
            <?php if ($page_view_average > 1): ?>
                <button class="btn btn-primary" onclick="previous_btn_view_average()">&laquo; Précédant</button>
            <?php endif ?>
            <?php if ($page_view_average < $pages_view_averages): ?>
                <button class="btn btn-primary ml-auto" onclick="next_btn_view_average()">Suivant &raquo;</button>
            <?php endif ?>
        </div>
    </div>
    <style>
        .image_logo_width {
            width: 50%;
        }
        .thead_tr_colspan {
            text-align: center;
            color: #fff;
            background-color:lightslategray;
        }
        .releve_title {
            width: fit-content;
            background-color: darkgray;
            border: 1px solid black;
            padding-left: 100px;
            padding-right: 100px;
        }
        .releve_title h1 {
            font-size: medium;
            font-family: 'Times New Roman', Times, serif;
        }

        .ml-auto {
            margin-left: auto;
        }
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
        .bg-gray td {
            font-weight: bolder;
        }
        .lightslategray {
            background-color: lightslategray;
            font-weight: bolder;
        }
        tr {
            border: none;
        }
        .lightslategray td {
            color: #fff;
            font-weight: bolder;
        }
        .border_complet {
            border: 1px solid black;
        }
        .table-header th{
            border: 1px solid black;
        }
        .border_bottom_none {
            border-bottom: 1px solid white;
            border-right: 1px solid black;
            background-color: #fff;
        }
        /* .end_border {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
        } */
        #releve {
            border: none;
        }
        .setBorderTop {
            border-top: 2px solid black;
        }
        /* #releve {
            width: 600px;
            height: 850px;
        } */
        #releve td, th {
            font-size: smaller;
        }
    </style>
    <script src="./node_modules/html2pdf.js/dist/html2pdf.bundle.min.js"></script>
    <script>
        let studies = document.getElementById('study_header');
        let radioGroup = document.getElementById('radioGroupes');
        let radioExamType = document.getElementById('radioExamType');
        let radioExam = document.getElementById('radioExam');
        let radio;
        let exam_type;
        relevePrint = () => {
            let releve = document.getElementById('releve');
            var opt = {
                margin:       0,
                filename:     'myfile.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { dpi: 192, letterRendering: true },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };
            html2pdf().from(releve).set(opt).output('dataurlnewwindow');
        }
        if (studies.firstChild) {
            setTimeout(() => {
                radio = sendStudyAverage(studies);
            }, 100);
        }
        select_study = (select) => {
            radio = sendStudyAverage(select);
            document.location = 'displayDashboard';
        }
        setTimeout(() => {
            if (radioExamType.querySelector('input[type="radio"]:checked')) {
                let exam_type_2 = radioExamType.querySelector('input[type="radio"]:checked');
                exam_type = exam_type_2.value;
                sendExamTypeAverage(exam_type_2);
            }
        }, 200);
    
        setTimeout(() => {
            if (radioExam.querySelector('input[type="radio"]:checked')) {
                let exam_name = radioExam.querySelector('input[type="radio"]:checked');
                sendExamAverage(exam_name);
            }
        }, 300);
       
        radioExamType.addEventListener('change', (event) => {
            if (event.target.type = 'radio') {
                exam_type = event.target.value;
                if (event.target.value == 'Examen') {
                    // deleting exams
                    let radioExam = document.getElementById('radioExam');
                    radioExam.style.display = 'none';
                    sendChangeReleveExam(event.target);
                } else {
                    let releveTable = document.getElementById('releveTable');
                    releveTable.style.display = '';
                    sendExamTypeAverage(event.target);
                    setTimeout(() => {
                        if (radioExam.querySelector('input[type="radio"]:checked')) {
                            let exam = radioExam.querySelector('input[type="radio"]:checked');
                            sendExamAverage(exam);
                        }
                    }, 100);
                }
            }
        })
        radioExam.addEventListener('change', (event) => {
            if (event.target.type == 'radio') {
                sendExamAverage(event.target);
            }
        })
        radioGroup.addEventListener('change', (event) => {
            if (event.target.type == 'radio') {
                radio = event.target.value;
                if (exam_type == 'Examen') {
                    sendGroupAverage(event.target, 'releveExam', ChangeReleveExam);
                } else {
                    sendGroupAverage(event.target, 'releve', ChangeReleve);
                }
            }
        })
        previous_btn_view_average = () => {
            if (exam_type == 'Examen') {
                sendNextPrevious('previous', exam_type, 'releveExam', ChangeReleveExam);
            } else {
                sendNextPrevious('previous', exam_type, 'releve', ChangeReleve);
            }
        }
        next_btn_view_average = () => {
            if (exam_type == 'Examen') {
                sendNextPrevious('next', exam_type, 'releveExam', ChangeReleveExam);
            } else {
                sendNextPrevious('next', exam_type, 'releve', ChangeReleve);
            }
        }
        let indentifier_view_average = document.getElementById('indentifier_view_average');
        indentifier_view_average.addEventListener('keydown', event => {
            if (event.key == 'Enter') {
                sendIdentifierSingle();
            }
        })
        SearchIdentifierViewAverage = () => {
            sendIdentifierSingle();
        }
        function sendIdentifierSingle() {
            let indentifier_view_average = document.getElementById('indentifier_view_average');
            if (!indentifier_view_average.value) {
                indentifier_view_average.style.backgroundColor = 'red';
            } else {
                indentifier_view_average.style.backgroundColor = '#fff';
            }
            

            if (exam_type == 'Examen') {
                url_send = 'releveExam';
            } else {
                url_send = 'releve';
            }
            $.ajax({
                type: 'post',
                url: url_send,
                data: {
                    'select': 'identifier',
                    'value': indentifier_view_average.value
                },
                success: s => {
                    let error = document.getElementById('error');
                    if (s == 0) {
                        error.style.display = '';
                        error.textContent = 'Le matricule n\'existe pas';
                        error.className = 'alert alert-danger text-center m-auto mb-2';
                    } else {
                        error.style.display = 'none';
                        if (exam_type == 'Examen') {
                            displayErrorReleve(ChangeReleveExam, s);
                        } else {
                            displayErrorReleve(ChangeReleve, s);
                        }
                    }
                }, 
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
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
        function sendGroupAverage(select, url_send, action) {
            $.ajax({
                type: 'post',
                url: url_send,
                data: {
                    'select': 'group',
                    'value': select.value
                }, 
                success: s => {
                    displayErrorReleve(action, s);
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
        function sendExamTypeAverage(select) {
            let exam = '<?= $exam_name ?>';
            $.ajax({
                type: 'post',
                url: 'ajax',
                data: {
                    'select': 'exam_type',
                    'value': select.value
                },
                success: s => {
                    let parsed = JSON.parse(s);
                    let error = document.getElementById('error');
                    error.style.display = 'none';
                    let radioExam = document.getElementById('radioExam');
                    radioExam.style.display = '';
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
                        if (element == exam) {
                            input.setAttribute('checked', 'checked');
                        }
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
        function sendExamAverage(select) {
            $.ajax({
                type: 'post',
                url: 'releve',
                data: {
                    'select': 'exam',
                    'value': select.value
                },
                success: s => {
                    let thead_view_average = document.getElementById('thead_view_average');
                    while (thead_view_average.firstChild) {
                        thead_view_average.removeChild(thead_view_average.firstChild);
                    }
                    let thead_tr = document.createElement('tr');
                    thead_tr.className = 'table-header bg-gray';
                    let th_1 = document.createElement('th');
                    th_1.textContent = 'Unités de Formation';
                    let th_2 = document.createElement('th');
                    th_2.textContent = 'Coeff.';
                    let th_3 = document.createElement('th');
                    th_3.textContent = select.value;
                    let th_4 = document.createElement('th');
                    th_4.textContent = 'Appréciations';
                    thead_tr.appendChild(th_1);
                    thead_tr.appendChild(th_2);
                    thead_tr.appendChild(th_3);
                    thead_tr.appendChild(th_4);

                    let thead_tr_colspan = document.createElement('tr');
                    let th_colspan = document.createElement('th');
                    th_colspan.textContent = 'Domaines de formation principaux';
                    th_colspan.className = 'border_complet thead_tr_colspan';
                    th_colspan.colSpan = 4;
                    thead_tr_colspan.appendChild(th_colspan);
                    thead_view_average.appendChild(thead_tr);
                    thead_view_average.appendChild(thead_tr_colspan);

                    ChangeReleve(s);
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
        function sendNextPrevious(btn, exam_type, url_send, action) {
            $.ajax({
                type: 'post',
                url: url_send,
                data: {
                    'select': btn,
                    'value': 1
                },
                success: s => {
                    let parsed = JSON.parse(s);
                    changeStudentInfo(parsed);
                    displayErrorReleve(action, s);
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
        function displayErrorReleve(action, s) {
            let parsed = JSON.parse(s);
            let releveTable = document.getElementById('releveTable');
            let error = document.getElementById('error');
            if (parsed.action == 'error') {
                error.style.display = '';
                changeStudentInfo(parsed);
                error.className = 'text-center alert alert-danger m-auto mb-2';
                error.textContent = 'Le relevé n\'est pas disponible';
                releveTable.style.display = 'none';
            } else {
                releveTable.style.display = '';
                error.style.display = 'none';
                action(s);
            }
        }
        function createNextPreviousButton(s) {
            let parsed = JSON.parse(s);
            let btn_next_previous = document.getElementById('btn_next_previous');
            while (btn_next_previous.firstChild) {
                btn_next_previous.removeChild(btn_next_previous.firstChild);
            }
            let pages_view_averages = parsed.pages_view_averages;
            let page_view_average = parsed.page_view_average;
            if (page_view_average >= 1) {
                let previous = document.createElement('button');
                previous.className = 'btn btn-primary';
                previous.setAttribute('onclick', 'previous_btn_view_average()');
                previous.textContent = 'Précédant';
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
        function ChangeReleve(s) {
            let parsed = JSON.parse(s);
            createNextPreviousButton(s);
            //releve title
            let releve_title = document.getElementById('releve_title');
            while (releve_title.firstChild) {
                releve_title.removeChild(releve_title.firstChild);
            }
            //thead
            let h1_releve_title = document.createElement('h1');
            let strong_releve_title = document.createElement('strong');
            strong_releve_title.textContent = 'RELEVE DE NOTES ET RESULTATS';
            h1_releve_title.appendChild(strong_releve_title); 
            releve_title.appendChild(h1_releve_title);
            changeStudentInfo(parsed);

            //tbody
            let tbody_average_view = document.getElementById('tbody_average_view');
            while (tbody_average_view.firstChild) {
                tbody_average_view.removeChild(tbody_average_view.firstChild);
            }
            let averages = parsed.averages;
            averages.forEach(element => {
                let tr = document.createElement('tr');
                let module_td = document.createElement('td');
                module_td.className = 'border_complet';
                module_td.textContent = element.name_module;
                let value_average_td = document.createElement('td');
                value_average_td.className = 'border_complet';
                value_average_td.textContent = element.value_average;
                let factor_td = document.createElement('td');
                factor_td.className = 'border_complet';
                factor_td.textContent = element.factor;
                let td_appreciation = document.createElement('td');
                td_appreciation.className = 'border_bottom_none';
                tr.appendChild(module_td);
                tr.appendChild(factor_td);
                tr.appendChild(value_average_td);
                tr.appendChild(td_appreciation);
                tbody_average_view.appendChild(tr);
            });

            //tfoot
            let total_module = parsed.total_module;
            let average = parsed.average;
            let tr = document.createElement('tr');
            tr.className = 'setBorderTop';
            let moyenne = document.createElement('td');
            moyenne.colSpan = '2';
            moyenne.className = 'bg-gray border_complet';
            let strong = document.createElement('strong');
            strong.textContent = 'Moyenne des notes sur 20';
            moyenne.appendChild(strong);
            let moyenne_val = document.createElement('td');
            moyenne_val.className = 'bg-gray border_complet';
            let strong2 = document.createElement('strong');
            strong2.textContent = (averages.length == total_module) ? average : 'NI';
            moyenne_val.appendChild(strong2);
            tr.appendChild(moyenne);
            tr.appendChild(moyenne_val);
            tbody_average_view.appendChild(tr);
        }
        function sendChangeReleveExam(select) {
            $.ajax({
                type: 'post',
                url: 'releveExam',
                data: {
                    'select': 'exam_type',
                    'value': select.value
                },
                success: s => {
                    displayErrorReleve(ChangeReleveExam, s);
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            })
        }
        function ChangeReleveExam(s) {
            let parsed = JSON.parse(s);
            changeStudentInfo(parsed);
            createNextPreviousButton(s);
            
            // data
            let total_coeff = parsed.total_factor;
            let total_controls = parsed.total_controls;
            let total_exam_theorique = parsed.total_exam_theorique;
            let total_exam_pratique = parsed.total_exam_pratique;
            let averages = parsed.averages;

            //data general averages 
            let ga_control_value = parsed.ga_control_value;
            let ga_exam_theorique_value = parsed.ga_exam_theorique_value;
            let ga_exam_pratique_value = parsed.ga_exam_pratique_value;

            //data final average
            let fa_value = parsed.fa_value;

            //releve title
            let releve_title = document.getElementById('releve_title');
            while (releve_title.firstChild) {
                releve_title.removeChild(releve_title.firstChild);
            }
            let h1_releve_title = document.createElement('h1');
            let strong_releve_title = document.createElement('strong');
            strong_releve_title.textContent = 'RELEVE DE NOTES ET RESULTATS';
            let brElement = document.createElement('br');
            strong_releve_title.appendChild(brElement);
            let h4_releve_title = document.createElement('h5');
            h4_releve_title.textContent = '(Examen De Passage)';
            h4_releve_title.style.fontSize = 'smaller';
            h4_releve_title.className = 'text-center';
            strong_releve_title.appendChild(h4_releve_title);
            h1_releve_title.appendChild(strong_releve_title); 
            releve_title.appendChild(h1_releve_title);

            //thead
            let thead_view_average = document.getElementById('thead_view_average');
            while (thead_view_average.firstChild) {
                thead_view_average.removeChild(thead_view_average.firstChild);
            }
            let thead_tr = document.createElement('tr');
            thead_tr.className = 'table-header bg-gray';
            let th_1 = document.createElement('th');
            th_1.textContent = 'Unités de Formation';
            let th_2 = document.createElement('th');
            th_2.textContent = 'Coeff.';
            let th_3 = document.createElement('th');
            th_3.innerHTML = 'MCC';
            let th_4 = document.createElement('th');
            th_4.innerHTML = 'MEFCFT';
            let th_5 = document.createElement('th');
            th_5.innerHTML = 'MEFCFP';
            let th_6 = document.createElement('th');
            th_6.textContent = 'Appréciations';
            thead_tr.appendChild(th_1);
            thead_tr.appendChild(th_2);
            thead_tr.appendChild(th_3);
            thead_tr.appendChild(th_4);
            thead_tr.appendChild(th_5);
            thead_tr.appendChild(th_6);
            thead_view_average.appendChild(thead_tr);

            //tbody
            let tbody_average_view = document.getElementById('tbody_average_view');
            while (tbody_average_view.firstChild) {
                tbody_average_view.removeChild(tbody_average_view.firstChild);
            }

            averages.forEach(element => {
                let tr_tbody = document.createElement('tr');
                let td_module = document.createElement('td');
                td_module.className = 'border_complet';
                td_module.textContent = element.name_module;
                let td_factor = document.createElement('td');
                td_factor.className = 'border_complet';
                td_factor.textContent = element.factor;
                let td_controls = document.createElement('td');
                td_controls.className = 'border_complet';
                td_controls.textContent = element.controles;
                let td_theorical = document.createElement('td');
                td_theorical.className = 'border_complet';
                td_theorical.textContent = element.theorical;
                let td_pratical = document.createElement('td');
                td_pratical.className = 'border_complet';
                td_pratical.textContent = element.pratical;
                let td_appreciation = document.createElement('td');
                td_appreciation.className = 'border_bottom_none';
                tr_tbody.appendChild(td_module);
                tr_tbody.appendChild(td_factor);
                tr_tbody.appendChild(td_controls);
                tr_tbody.appendChild(td_theorical);
                tr_tbody.appendChild(td_pratical);
                tr_tbody.appendChild(td_appreciation);
                tbody_average_view.appendChild(tr_tbody);
            });

            // total tbody
            let total_tbody = document.createElement('tr');
            total_tbody.className = 'setBorderTop';
            let total_text = document.createElement('td');
            total_text.className = 'lightslategray border_complet';
            total_text.textContent = 'Total';
            let total_coeff_td = document.createElement('td');
            total_coeff_td.className = 'lightslategray border_complet';
            total_coeff_td.textContent = total_coeff;
            let total_controls_td = document.createElement('td');
            total_controls_td.className = 'lightslategray border_complet';
            total_controls_td.textContent = total_controls;
            let total_exam_theorique_td = document.createElement('td');
            total_exam_theorique_td.className = 'lightslategray border_complet';
            total_exam_theorique_td.textContent = total_exam_theorique;
            let total_exam_pratique_td = document.createElement('td');
            total_exam_pratique_td.className = 'lightslategray border_complet';
            total_exam_pratique_td.textContent = total_exam_pratique;
            let td_appreciation = document.createElement('td');
            total_tbody.appendChild(total_text);
            total_tbody.appendChild(total_coeff_td);
            total_tbody.appendChild(total_controls_td);
            total_tbody.appendChild(total_exam_theorique_td);
            total_tbody.appendChild(total_exam_pratique_td);
            total_tbody.appendChild(td_appreciation);

            tbody_average_view.appendChild(total_tbody);

            //General averages
            let general_average = document.createElement('tr');
            let ga_title = document.createElement('td');
            ga_title.colSpan = 2;
            ga_title.className = 'bg-gray border_complet';
            ga_title.textContent = 'Moyenne Générale';
            let ga_control = document.createElement('td');
            ga_control.textContent = ga_control_value;
            ga_control.className = 'bg-gray border_complet';
            let ga_exam_theorique = document.createElement('td');
            ga_exam_theorique.textContent = ga_exam_theorique_value;
            ga_exam_theorique.className = 'bg-gray border_complet';
            let ga_exam_pratique = document.createElement('td');
            ga_exam_pratique.textContent = ga_exam_pratique_value;
            ga_exam_pratique.className = 'bg-gray border_complet';
            general_average.appendChild(ga_title);
            general_average.appendChild(ga_control);
            general_average.appendChild(ga_exam_theorique);
            general_average.appendChild(ga_exam_pratique);
            tbody_average_view.appendChild(general_average);

            //Final averages
            let final_average = document.createElement('tr');
            let fa_title = document.createElement('td');
            fa_title.colSpan = 2;
            fa_title.textContent = 'Moyenne finale';
            fa_title.className = 'lightslategray border_complet';
            let fa_value_td = document.createElement('td');
            fa_value_td.className = 'lightslategray border_complet';
            fa_value_td.colSpan = 3;
            fa_value_td.textContent = fa_value;
            final_average.appendChild(fa_title);
            final_average.appendChild(fa_value_td);
            tbody_average_view.appendChild(final_average);
        }
        function changeStudentInfo(parsed) {
            let student_info = document.getElementById('student_info');
            let identifier = parsed.identifier;
            let year = parsed.year;
            let study = parsed.study;
            let group = parsed.group;
            let full_name = parsed.full_name;
            while(student_info.firstChild) {
                student_info.removeChild(student_info.firstChild);
            }
            student_info.innerHTML = 'Matricule : <strong>'+identifier+'</strong><br>Filière: <strong>'+study+'</strong><br>Niveau: <strong>'+((group == 1) ? '1ère année' : '2ème année')+'</strong><br>Année de formation: <strong>'+(parseInt(year)-1)+'/'+year+'</strong><br>Nom et prénom: <strong>'+full_name+'</strong><br>';
            
        }
        let tr = document.querySelectorAll('tr');
        tr.forEach(element => {
            element.style.border = 'none';
        })
    </script>
<?php 
$insert_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>
