if (window.location.pathname == '/ipem/displayDashboard' || window.location.pathname == '/ipem/home') {
    document.addEventListener('DOMContentLoaded', () => {
        let year = document.getElementById('year');
        let studies = document.getElementById('study_header');
        let groupes = document.getElementById('group');
        let exam_type = document.getElementById('exam_type');
        let exam = document.getElementById('exam');
        let module = document.getElementById('module');
        let session_average = sessionStorage.getItem('average');
        if (session_average != 1 || session_average == undefined) {
            $('#individual_insert').hide();
        }
        nav_top_a = (a) => {
            let nav_top = a.getAttribute('data-value');
            sendValueSession({'nav_top': nav_top}, document.location = 'displayDashboard');
            console.log(nav_top)
        }
        nav_left_button = (button) => {
            let nav_left = button.getAttribute('data-value');
            sendValueSession(
                {'nav_left': nav_left, 'value': true, 'year': year.value},
                document.location = 'displayDashboard'
            );
            if (nav_left == 'average') {
                sessionStorage.setItem('average', 1)
            } else {
                sessionStorage.setItem('average', 0)
            }
        }
        if (year.value) {
            sendYear(year);
        }
        if (studies.firstChild) {
            setTimeout(() => {
                sendStudy(studies);
            }, 100);
        }
        if (groupes.firstChild) {
            setTimeout(() => {
                sendGroup(groupes);
            },400);
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
        select_year = (select) => {
            sendYear(select);
        }
        select_study = (select) => {
            sendStudy(select);
        }
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
        next_button_average = (button) => {
            sendValueSession({'current_page': currentPage+1}, document.location = 'displayDashboard');
        }
        previous_button_average = (button) => {
            sendValueSession({'current_page': currentPage-1}, document.location = 'displayDashboard');
        }
    });

    function sendYear(select) {
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
}
