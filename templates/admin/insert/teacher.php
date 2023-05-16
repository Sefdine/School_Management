<!-- Teacher -->
<?php ob_start(); ?>
<div class="admin container">
    <div id="error"></div>
    <div class="d-flex mt-2 m-auto" style="width:fit-content;">
        <div class="ms-4" id="modulesFirstYearCheckbox">
            <h3 class="text-center mt-2">Modules de 1ère année</h3>
            <div class="mt-2 card first_year_modules p-3">
                <?php foreach($modules_first_year as $module): ?>
                    <div class="form-check">
                        <input type="checkbox" name="moduleCheckbox" id="<?= $module->slug ?>" value="<?= $module->slug ?>" class="form-check-input">
                        <label for="<?= $module->slug ?>" class="form-check-label"><?= $module->name ?></label>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
        <div class="ms-4" id="modulesSecondYearCheckbox">
            <h3 class="text-center mt-2">Modules de 2ème année</h3>
            <div class="mt-2 card first_year_modules p-3">
                <?php foreach($modules_second_year as $module): ?>
                    <div class="form-check">
                        <input type="checkbox" name="moduleCheckbox" id="<?= $module->slug ?>" value="<?= $module->slug ?>" class="form-check-input">
                        <label for="<?= $module->slug ?>" class="form-check-label"><?= $module->name ?></label>
                    </div>
                <?php endforeach ?>
            </div>
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
        <span class="input-group-text">Identifiant *</span>
        <input type="text" name="identifier" id="identifier" class="form-control" required>
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
    .first_year_modules {
        background-color: darkgrey;
        color: #fff;
    }
    .input-group-text {
        width: 20%;
    }
</style>
<script>
    let studies = document.getElementById('study_header');

    function sendGroupTeacher(radioGroup) {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'group',
                'value': radioGroup.value
            },
            success: s => {
                changeModules(s);
            },
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    function changeModules(s) {
        let parsed = JSON .parse(s);
        console.log(parsed)
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
        });
    }
    insert_teacher_btn = (btn) => {
        let moduleFirstYearChecked = [];
        let moduleSecondYearChecked = [];
        modulesFirstYearCheckbox.querySelectorAll('input[type="checkbox"]:checked').forEach(element => {
            moduleFirstYearChecked.push(element.value);
        })
        modulesSecondYearCheckbox.querySelectorAll('input[type="checkbox"]:checked').forEach(element => {
            moduleSecondYearChecked.push(element.value);
        })
        let lastname = document.getElementById('lastname');
        let firstname = document.getElementById('firstname');
        let identifier = document.getElementById('identifier');
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
        if (moduleFirstYearChecked.length === 0 && moduleSecondYearChecked.length === 0) {
            error.textContent = 'Veuillez cocher au moin un module';
        } else if (!lastname.value) {
            error.textContent = 'Veuillez remplir le champs Nom';
            lastname.style.backgroundColor = 'red';
        } else if (!firstname.value) {
            error.textContent = 'Veuillez remplir le champs Prénom';
            firstname.style.backgroundColor = 'red';
            lastname.style.backgroundColor = '#fff';
        } else if (!identifier.value) {
            error.textContent = 'Veuillez remplir le champs Identifiant';
            identifier.style.backgroundColor = 'red';
            lastname.style.backgroundColor = '#fff';
            firstname.style.backgroundColor = '#fff';
        } else {
            firstname.style.backgroundColor = '#fff';
            lastname.style.backgroundColor = '#fff';
            identifier.style.backgroundColor = '#fff';
            error.style.display = 'none';
            data['firstname'] = firstname.value;
            data['lastname'] = lastname.value;
            data['identifier'] = identifier.value;
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
                    'modulesFirstYear': moduleFirstYearChecked,
                    'modulesSecondYear': moduleSecondYearChecked,
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