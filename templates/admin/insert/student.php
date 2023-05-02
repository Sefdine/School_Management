<!-- Student -->
<?php ob_start() ?>
<div class="admin container">
    <div id="error"></div>
    <div id="radioGroupes">
    </div>
    <h1>Insérer un étudiant</h1>
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
            <span class="input-group-text">Numéro d'inscription *</span>
            <input type="text" name="identifier" id="identifier" class="form-control" required>
        </div>
        <div class="input-group">
            <span class="input-group-text">Lieu de naissance</span>
            <input type="text" name="place_birth" id="place_birth" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Date de naissance</span>
            <input type="date" name="birthday" id="birthday" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Date d'inscription</span>
            <input type="date" name="registration_date" id="registration_date" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Nationalité</span>
            <input type="text" name="nationality" id="nationality" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">CIN ou passeport</span>
            <input type="text" name="cin" id="cin" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Genre</span>
            <select name="gender" id="gender" class="form-select">
                <option value="male">M</option>
                <option value="female">F</option>
            </select>
        </div>
        <div class="input-group">
            <span class="input-group-text">Adresse</span>
            <input type="text" name="address" id="address" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Niveau</span>
            <input type="text" name="level_study" id="level_study" class="form-control">
        </div>
        <div class="input-group">
            <span class="input-group-text">Date d'entrée au Maroc</span>
            <input type="date" name="entry_date" id="entry_date" class="form-control">
        </div>
        <input type="submit" value="Insérer" onclick="insertStudentBtn()" class="btn btn-primary">
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
        width: 30%;
    }
</style>
<script>
    let studies = document.getElementById('study_header');
    let radioGroup = document.getElementById('radioGroupes');
    let radio;
    if (studies.firstChild) {
        setTimeout(() => {
            radio = sendStudyStudent(studies);
        }, 100);
    }
    select_study = (select) => {
        radio = sendStudyStudent(select);
    }
    radioGroup.addEventListener('change', (event) => {
        if (event.target.type == 'radio') {
            radio = event.target.value;
            sendGroupStudent(event.target);
        }
    })
    insertStudentBtn = () => {
        let lastname = document.getElementById('lastname');
        let firstname = document.getElementById('firstname');
        let identifier = document.getElementById('identifier');
        let place_birth = document.getElementById('place_birth');
        let birthday = document.getElementById('birthday');
        let registration_date = document.getElementById('registration_date');
        let nationality = document.getElementById('nationality');
        let cin = document.getElementById('cin');
        let gender = document.getElementById('gender');
        let address = document.getElementById('address');
        let level_study = document.getElementById('level_study');
        let entry_date = document.getElementById('entry_date');
        let data = {};

        let error = document.getElementById('error');
        error.className = 'alert alert-danger text-center';
        error.style.display = '';
        if (!radio) {
            error.textContent = 'Veuillez choisir un groupe';
        } else if (!lastname.value) {
            error.textContent = 'Veuillez remplir le champs Nom';
            lastname.style.backgroundColor = 'red';
        } else if (!firstname.value) {
            error.textContent = 'Veuillez remplir le champs Prénom';
            firstname.style.backgroundColor = 'red';
            lastname.style.backgroundColor = '#fff';
        } else if (!identifier.value) {
            error.textContent = 'Veuillez remplir le numéro d\'inscrition';
            identifier.style.backgroundColor = 'red';
            firstname.style.backgroundColor = '#fff';
            lastname.style.backgroundColor = '#fff';
        } else {
            firstname.style.backgroundColor = '#fff';
            lastname.style.backgroundColor = '#fff';
            identifier.style.backgroundColor = '#fff';
            error.style.display = 'none';
            data['firstname'] = firstname.value;
            data['lastname'] = lastname.value;
            data['identifier'] = identifier.value;
            data['place_birth'] = place_birth.value;
            data['registration_date'] = registration_date.value;
            data['nationality'] = nationality.value;
            data['cin'] = cin.value;
            data['gender'] = gender.value;
            data['address'] = address.value;
            data['level_study'] = level_study.value;
            data['entry_date'] = entry_date.value;

            $.ajax({
                type: 'post',
                url: 'insertStudent',
                data: {
                    'group': radio,
                    'data': JSON.stringify(data) 
                },
                success: s => {
                    console.log(s);
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
    function sendGroupStudent(select) {
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
</script>
<?php 
$insert_student = ob_get_clean(); 
require_once('templates/admin/dashboard.php');
?>