<!-- Average -->
<?php ob_start(); ?>
<div class="admin container">
    <div class="input-group mb-1">
        <span class="input-group-text">Group</span>
        <select name="group" id="group" onchange="select_group(this)" class="form-select">
            <?php foreach($groupes as $item): ?>
                <option value="<?= $item->slug ?>" <?= ($item->slug == $group) ? 'selected' : '' ?>><?= $item->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="input-group mb-1">
        <span class="input-group-text">Type d'exam</span>
        <select name="exam_type" id="exam_type" onchange="select_type_exam(this)" class="form-select">
            <?php foreach($exams_types as $item): ?>
                <option value="<?= $item ?>" <?= ($item == $exam_type) ? 'selected' : '' ?>><?= $item ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="input-group mb-1">
        <span class="input-group-text">Exams</span>
        <select name="exam" id="exam" onchange="select_exam(this)" class="form-select">
            <?php foreach($exams as $item): ?>
                <option value="<?= $item ?>" <?= ($item == $exam) ? 'selected' : '' ?>><?= $item ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="input-group mb-1">
        <span class="input-group-text">Modules</span>
        <select name="module" id="module" onchange="select_module(this)" class="form-select">
            <?php foreach($modules as $module): ?>
                <option value="<?= $module->slug ?>" <?= ($module->slug == $current_module) ? 'selected' : '' ?>><?= $module->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <hr>
    <form action="<?= URL_ROOT ?>insertAverages" method="post" class="form-group">
        <table class="table table-light">
            <thead>
                <th>#</th>
                <th>Nom et prénom</th>
                <th>Numéro d'inscription</th>
                <th>Note</th>
            </thead>
            <tbody class="table-group-divider">
                <?php foreach($data_users as $k => $line): ?>
                    <tr>
                        <td><?= ($k+1)+($currentPage-1)*10 ?></td>
                        <td><?= $line->firstname .' '. $line->lastname ?></td>
                        <td><?= $line->identifier ?></td>
                        <td><input type="number" step="0.1" name="<?= $line->identifier ?>" min="0" max="20"></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <input type="submit" onclick="submit_averages(this)" value="Insérer les notes" class="submit_average">
    </form>
    <div class="d-flex justify-content-between my-2">
        <?php if ($currentPage > 1): ?>
            <button class="btn btn-primary" onclick="previous_button_average(this)">&laquo; Précédant</button>
        <?php endif ?>
        <?php if ($currentPage < $pages): ?>
            <button class="btn btn-primary ml-auto" onclick="next_button_average(this)">Suivant &raquo;</button>
        <?php endif ?>
    </div>
</div>
<style>
        td, th {
            color: #000;
        }
        input {
            border: 1px solid blue;
            text-align: center;
            height: 30px;
        }
        .ml-auto {
            margin-left: auto;
        }
        .input-group-text {
            width: 20%;
        }
</style>
<script>
    let studies = document.getElementById('study_header');
    let currentPage = <?= $currentPage ?>;
    let groupes = document.getElementById('group');
    let exam_type = document.getElementById('exam_type');
    let exam = document.getElementById('exam');
    let module = document.getElementById('module');
    
    select_group = (select) => {
        sendGroup(select);
    }
    select_type_exam = (select) => {
        sendTypeExam(select);
    }
    select_exam = (select) => {
        sendExam(select);
    }
    select_module = (select) => {
        sendModule(select);
    }
    select_study = (select) => {
        sendStudy(select);
    }
    if (studies.firstChild) {
        setTimeout(() => {
            sendStudy(studies);
        }, 100);
    }
    if (groupes.firstChild) {
        setTimeout(() => {
            sendGroup(groupes);
        }, 400);
    }
    if (exam_type.value) {
        setTimeout(() => {
            sendTypeExam(exam_type);
        }, 300);
    }
    if (exam.firstChild) {
        setTimeout(() => {
            sendExam(exam);
        }, 300);
    }
    if (module.firstChild) {
        setTimeout(() => {
            sendModule(module);
        },100);
    }

    function sendStudy(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'study',
                'value': select.value
            },
            success: s => {
                let parsed = JSON.parse(s);
                let groupes = document.getElementById('group');
                while(groupes.firstChild) {
                    groupes.removeChild(groupes.firstChild);
                }
                parsed.forEach(element => {
                    let option = document.createElement('option');
                    option.value = element;
                    option.textContent = (element == 1) ? '1ère année' : '2ème année';
                    groupes.appendChild(option);

                });
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function sendGroup(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'group',
                'value': select.value
            },
            success: s => {
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        })
    }
    function sendTypeExam(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'exam_type',
                'value': select.value
            },
            dataType: 'json',
            success: s => {
                let exams = document.getElementById('exam');
                while (exams.firstChild) {
                    exams.removeChild(exams.firstChild);
                }
                s.forEach(element => {
                    let option = document.createElement('option');
                    option.value = element;
                    option.textContent = element;
                    exams.appendChild(option);
                });
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function sendExam(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'exam',
                'value': select.value
            },
            success: s => {
                let parsed = JSON.parse(s);
                let modules = document.getElementById('module');
                while (modules.firstChild) {
                    modules.removeChild(modules.firstChild);
                }
                parsed.forEach(element => {
                    let option = document.createElement('option');
                    option.value = element.slug;
                    option.textContent = element.name;
                    modules.appendChild(option);
                })
            },
            error: (xhr, textStatus, errorThrown) => {
                console.log(errorThrown);
            }
        });
    }
    function sendModule(select) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'module',
                'value': select.value
            },
            success: s => {
                let parsed = JSON.parse(s);
                let tbody = document.querySelector('.table-group-divider');
                while (tbody.firstChild) {
                    tbody.removeChild(tbody.firstChild);
                }
                parsed.forEach(element => {
                    let tr = document.createElement('tr');
                    let number = document.createElement('td');
                    number.textContent = 1;
                    let name = document.createElement('td');
                    name.textContent = element.firstname +' '+element.lastname;
                    let identifier = document.createElement('td');
                    identifier.textContent = element.identifier;
                    let average = document.createElement('td');
                    let input = document.createElement('input');
                    input.setAttribute('type', 'number');
                    input.setAttribute('step', '0.1');
                    input.setAttribute('name', element.identifier);
                    input.setAttribute('min', '0');
                    input.setAttribute('max', '20');
                    average.appendChild(input);
                    tr.appendChild(number);
                    tr.appendChild(name);
                    tr.appendChild(identifier);
                    tr.appendChild(identifier);
                    tr.appendChild(average);
                    tbody.appendChild(tr);
                })
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
</script>
<?php 
$insert_average = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>