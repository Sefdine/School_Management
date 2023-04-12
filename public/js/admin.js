$(document).ready(() => {
    nav_top_a = (a) => {
        let nav_top = a.getAttribute('data-value');
        sendValueSession({'nav_top': nav_top}, document.location = 'displayDashboard');
        console.log(nav_top)
    }
    nav_left_button = (button) => {
        let year = (document.getElementById('year')).value;
        let nav_left = button.getAttribute('data-value');
        sendValueSession(
            {'nav_left': nav_left, 'value': true, 'year': year},
            document.location = 'displayDashboard'
        );
        if (nav_left == 'average') {
            sessionStorage.setItem('study', 1)
        } else {
            sessionStorage.setItem('study', 0)
        }
    }
    let session_study = sessionStorage.getItem('study');
    if (session_study != 1 || session_study == undefined) {
        $('#individual_insert').hide();
    }
    resetTable = (button) => {
        sendValueSession({'value': true}, document.location = 'displayDashboard');
    }
    select_year = (select) => {
        $.ajax({
            type: 'post',
            url: 'ajax',
            data: {
                'select': 'year',
                'value': select.value
            },
            dataType: 'json',
            success: s => {
                let studies = document.getElementById('study_header');
                while (studies.firstChild) {
                    studies.removeChild(studies.firstChild);
                }
                let option = document.createElement('option');
                option.value = 'title';
                option.setAttribute('disabled', 'disabled');
                option.setAttribute('selected', 'selected');
                option.className ='text-center';
                option.textContent = 'Choisir une filière';
                studies.appendChild(option);
                s.forEach(element => {
                    let option = document.createElement('option');
                    option.value = element;
                    option.className ='text-center';
                    option.textContent = element;
                    studies.appendChild(option);
                });
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    select_study = (select) => {
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
                let option = document.createElement('option');
                option.value = 'title';
                option.setAttribute('disabled', 'disabled');
                option.setAttribute('selected', 'selected');
                option.textContent = 'Choisir un groupe';
                groupes.appendChild(option);
                parsed.forEach(element => {
                    let option = document.createElement('option');
                    option.value =element;
                    option.textContent = (element == 1) ? '1ère année' : '2ème année';
                    groupes.appendChild(option);

                });
            }, 
            error: (xhr, textStatus, errorThrown) => {
                console.error(errorThrown);
            }
        });
    }
    select_group = (select) => {
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
    select_type_exam = (select) => {
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
                let option = document.createElement('option');
                option.value = 'title';
                option.setAttribute('selected', 'selected');
                option.setAttribute('disabled', 'disabled');
                if (select.value == 'Examen') {
                    option.textContent = 'Choisir un exam';
                } else {
                    option.textContent = 'Choisir un contrôle';
                }
                exams.appendChild(option);
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
        })
    }
    select_exam = (select) => {
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
                let option = document.createElement('option');
                option.value = 'title';
                option.setAttribute('selected', 'selected');
                option.setAttribute('disabled', 'disabled');
                option.textContent = 'Choisir un module';
                modules.appendChild(option);
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
    select_module = (select) => {
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
        })
    }
    next_button_average = (button) => {
        sendValueSession({'current_page': currentPage+1}, document.location = 'displayDashboard');
    }
    previous_button_average = (button) => {
        sendValueSession({'current_page': currentPage-1}, document.location = 'displayDashboard');
    }
});


function sendValueSession(data, action) {
    $.ajax({
        type: 'POST',
        url: 'displayDashboard',
        data: data,
        success: s => {
            action;
        },
        error: (error) => {
            console.error(error);
        }
    })
}
