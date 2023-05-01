<!-- Teacher -->
<?php ob_start(); ?>
<div class="admin container">
    <div id="error"></div>
    <div class="row">
        <div id="radioGroupes" class="col-md-4 ms-4">
            <h3>Choisissez un groupe</h3>
        </div>
        <div class="col-md-6 ms-3" id="modulesTeacherCheckbox">
            <h3>Choisissez des modules</h3>
            <?php foreach($modules as $module): ?>
                <div class="form-check">
                    <input type="checkbox" name="moduleCheckbox" id="<?= $module->slug ?>" value="<?= $module->slug ?>" class="form-check-input">
                    <label for="<?= $module->slug ?>" class="form-check-label"><?= $module->name ?></label>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <h1>Insérer un enseignant</h1>
    <div class="form-group">
    <div class="input-group">
        <span class="input-group-text">Nom *</span>
        <input type="text" name="lastname" id="lastname" class="form-control" required>
    </div>
    <div class="input-group">
        <span class="input-group-text">Prénom *</span>
        <input type="text" name="firstname" id="firstname" class="form-control" required>
    </div>
    <div class="input-group">
        <span class="input-group-text">Email</span>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">GSM</span>
        <input type="text" name="tel" id="tel" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">CIN</span>
        <input type="text" name="cin" id="cin" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Adresse</span>
        <input type="text" name="address" id="address" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Diplome</span>
        <input type="text" name="degree" id="degree" class="form-control">
    </div>
    <div class="input-group">
        <span class="input-group-text">Expérience</span>
        <input type="number" name="experience" id="experience" class="form-control">
    </div>
        <input type="submit" value="Insérer" class="btn btn-primary" onclick="insert_teacher_btn(this)">
    </div>

    <div class="mt-5 mb-3 mx-auto"  style="width: 60%">
        <label for="formfile" class="form-label">Entrer un fichier</label>
        <div class="input-group">
            <input type="file" name="formFile" id="formFile" class="form-control" accept=".xls, .xlsx" aria-describedby="fromFileAria" aria-label="Upload">
            <button type="button" class="btn btn-outline-secondary" id="fromFileAria">Confirmer</button>
        </div>
    </div>
</div>
<style>
    .input-group-text {
        width: 20%;
    }
</style>
<script>
    let studies = document.getElementById('study_header');
    let moduleChecked = [];
    let radio;

    select_study = (select) => {
        radio = sendStudyTeacher(select);
    }
    if (studies.firstChild) {
        setTimeout(() => {
            radio = sendStudyTeacher(studies);
        }, 100);
    }

    let radioGroupes = document.getElementById('radioGroupes');
    radioGroupes.addEventListener('change', (event) => {
        if (event.target.type == 'radio') {
            sendGroupTeacher(event.target);
            radio = event.target.value;
            moduleChecked = [];
        }
    })

    let modulesCheckbox = document.getElementById('modulesTeacherCheckbox');
    modulesCheckbox.addEventListener('change', (evenet) => {
        if (evenet.target.type == 'checkbox') {
            moduleChecked.push(evenet.target.value);
        }
    })

    function sendStudyTeacher(select) {
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
        return group;
    }
    function sendGroupTeacher(radioGroup) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'group',
                'value': radioGroup.value
            },
            success: s => {
                let parsed = JSON .parse(s);
                let modules = document.getElementById('modulesTeacherCheckbox');
                while (modules.firstChild) {
                    modules.removeChild(modules.firstChild);
                }
                let h3 = document.createElement('h3');
                h3.textContent = 'Choisissez des modules';
                modules.appendChild(h3);
                parsed.forEach(element => {
                    let div = document.createElement('div');
                    div.className = 'form-check';
                    let input = document.createElement('input');
                    input.setAttribute('id', element.slug);
                    input.setAttribute('type', 'checkbox');
                    input.name = 'moduleCheckbox';
                    input.value = element.slug;
                    input.className = 'form-check-input';
                    let label = document.createElement('label');
                    label.setAttribute('for', element.slug);
                    label.className = 'form-check-label';
                    label.textContent = element.name;
                    div.appendChild(input);
                    div.appendChild(label);
                    modules.appendChild(div);
                })
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    insert_teacher_btn = (btn) => {
        let lastname = document.getElementById('lastname');
        let firstname = document.getElementById('firstname');
        let email = document.getElementById('email').value;
        let tel = document.getElementById('tel').value;
        let cin = document.getElementById('cin').value;
        let address = document.getElementById('address').value;
        let degree = document.getElementById('degree').value;
        let experience = document.getElementById('experience').value;
        let data = {};

        let error = document.getElementById('error');
        error.className = 'alert alert-danger text-center';
            error.style.display = '';
        if (!radio) {
            error.textContent = 'Veuillez choisir un groupe';
        } else if (moduleChecked.length === 0) {
            error.textContent = 'Veuillez cocher au moin un module';
        } else if (!lastname.value) {
            error.textContent = 'Veuillez remplir le champs Nom';
            lastname.style.backgroundColor = 'red';
        } else if (!firstname.value) {
            error.textContent = 'Veuillez remplir le champs Prénom';
            firstname.style.backgroundColor = 'red';
            lastname.style.backgroundColor = '#fff';
        } else {
            firstname.style.backgroundColor = '#fff';
            lastname.style.backgroundColor = '#fff';
            error.style.display = 'none';
            data['firstname'] = firstname.value;
            data['lastname'] = lastname.value;
            data['email'] = email;
            data['tel'] = tel;
            data['cin'] = cin;
            data['address'] = address;
            data['degree'] = degree;
            data['experience'] = experience;

            $.ajax({
                type: 'post',
                url: 'insertTeacher',
                data: {
                    'group': radio,
                    'modules': moduleChecked,
                    'data': JSON.stringify(data)
                },
                success: s => {
                    error.style.display = '';
                    if (s) {
                        error.className = 'alert alert-success text-center';
                        error.textContent = 'L\'insertion a reussi';
                    } else {
                        error.textContent = 'L\'insertion a echoué';
                    }
                },
                error: (xhr, textStatus, errorThrown) => {
                    console.error(errorThrown);
                }
            });
        }   
    }
</script>
<?php 
$insert_teacher = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>